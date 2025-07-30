<?php

namespace App\Jobs;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Queue\SerializesModels;
use App\Models\Document;
use PhpOffice\PhpWord\Element\Text;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\Element\TextBreak;
use PhpOffice\PhpWord\Element\Image;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use Smalot\PdfParser\Parser;
use PhpOffice\PhpWord\IOFactory as WordIOFactory;
use PhpOffice\PhpSpreadsheet\IOFactory as ExcelIOFactory;
use PhpOffice\PhpPresentation\IOFactory as PptIOFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Exception;
use XMLReader;
use ZipArchive;

class traitementQueueUploadFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Supprime le job de la file d'attente si les modèles ne sont plus présents.
     *
     * @var bool
     */
    public $deleteWhenMissingModels = true;


    const FILE_CHUNK_SIZE = 50; // 10KB
    const DB_BATCH_SIZE = 20;
    const EXCEL_ROW_CHUNK = 500;
    const PDF_PAGE_LIMIT = 1;

    protected $document;
    protected $mot_cle;
    protected $confidence;
    protected $buffer = '';
    protected $processedChunks = 5;

    public function __construct(Document $document, ?string $mot_cle = '', $confidence)
    {
        $this->document = $document;
        $this->mot_cle = (string)$mot_cle;
        $this->confidence =$confidence;
    }

    public function handle()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(0);

        try {
            
            $this->document->update(['status' => 'processing']);
            $fullPath = Storage::disk('public')->path($this->document->filename);
            $extension = strtolower(pathinfo($this->document->filename, PATHINFO_EXTENSION));
            $this->processByExtension($fullPath, $extension);
            $this->finalizeContent();
                // Journalisation
        ActivityLog::create([
            'action' => '✅extration pages terminée',
            'description' => $this->document->nom,
            'icon' => '...',
            'user_id' => Auth::id(),
            'confidentiel' => $this->confidence,
        ]);            
            $this->document->update(['status' => 'completed']);
            // Lancer la synchronisation avec Scout après le traitement
            Artisan::call('scout:import', ['model' => "App\Models\Document"]);


        } catch (Exception $e) {
            $this->document->update([
                'status' => 'failed',
                'error_message' => substr($e->getMessage(), 0, 255)
            ]);
            throw $e;
        }
    }

    private function processByExtension(string $path, string $extension)
    {
        switch ($extension) {
            case 'pdf':
                $this->processPdfChunked($path);
                break;          

            case 'xls':
            case 'xlsx':
            case 'csv':
                $pdf=$this->convertLargeFileToPDF($path);
                $this->processPdfChunked($pdf) ;
            break;
            case 'txt':
                $txt=$this->processLargeTxtFile($path);
                
            break; 
            case 'docx':
            case 'pptx':
            case 'doc':
                $pdf=$this->convertLargeFileToPDF($path); 
                $this->processPdfChunked($pdf) ;          
            break;
            
            
        }
    }

public function convertLargeFileToPDF($filePath)//convertion en pdf avec LibreOffice
{
    $outputDir = storage_path('app/public/archives/');
    if (!file_exists($outputDir)) {
        mkdir($outputDir, 0777, true);
    }
    $command = "soffice --headless --convert-to pdf " . escapeshellarg($filePath) . " --outdir " . escapeshellarg($outputDir);
    shell_exec($command);

      // Lancer la commande sans bloquer PHP
    $descriptorspec = [1 => ['pipe', 'w'], 2 => ['pipe', 'w']];
    $process = proc_open($command, $descriptorspec, $pipes);

    if (is_resource($process)) {
        fclose($pipes[1]);
        fclose($pipes[2]);
        proc_close($process);
    }

    return $outputDir .  pathinfo($filePath, PATHINFO_FILENAME) . '.pdf';
}


        /**
     * Convertir un fichier Word (DOCX) en PDF
     */
    /* bonne convertion pour word ancien model
    private function convertWordToPdf($filePath)
    {
        // 🔹 Créer le dossier s'il n'existe pas
        $storagePath = storage_path('app/public/archives/');
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0777, true);
        }
    
        // 🔹 Nom du fichier de sortie
        $outputFile = $storagePath . pathinfo($filePath, PATHINFO_FILENAME) . '.pdf';
    
        // 🔹 Charger le fichier Word
        //$phpWord = IOFactory::load($filePath);
        //$newPhpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord = \PhpOffice\PhpWord\IOFactory::load($filePath);
        $newPhpWord = new \PhpOffice\PhpWord\PhpWord();
    
        // 🔹 Récupérer les sections du document
        $sections = $phpWord->getSections();
        $pageLimit = 100; // Nombre maximum de pages
        $charPerPage = 300; // Approximation du nombre de caractères par page
        $wordContent = '';
    
        // 🔹 Parcourir les sections et récupérer le texte
        foreach ($sections as $section) {
            foreach ($section->getElements() as $element) {
                if ($element instanceof Text) {
                    $wordContent .= $element->getText() . "\n";
                } elseif ($element instanceof TextRun) {
                    foreach ($element->getElements() as $textElement) {
                        if ($textElement instanceof Text) {
                            $wordContent .= $textElement->getText() . "\n";
                        }
                    }
                } elseif ($element instanceof TextBreak) {
                    $wordContent .= "\n"; // Ajouter un saut de ligne
                } elseif ($element instanceof Image) {
                    $wordContent .= "[Image détectée]\n";
                } elseif ($element instanceof Table) {
                    $wordContent .= "[Tableau détecté]\n";
                }
            }
        }
    
        // 🔹 Découper le texte en pages
        $pages = explode("\f", wordwrap($wordContent, $charPerPage, "\f", true));
        $wordContent = implode("\n", array_slice($pages, 0, $pageLimit)); // Garde 50 pages max
    
        // 🔹 Ajouter le texte traité à un nouveau document
        $newSection = $newPhpWord->addSection();
        $newSection->addText($wordContent);
    
        // 🔹 Configurer le moteur PDF (TCPDF ou MPDF recommandé)
        Settings::setPdfRendererName(Settings::PDF_RENDERER_TCPDF); // Peut être MPDF aussi
        Settings::setPdfRendererPath(base_path('vendor/tecnickcom/tcpdf')); // Ou MPDF
    
        // 🔹 Écrire le fichier PDF
        //$writer = IOFactory::createWriter($newPhpWord, 'PDF');
        $writer = \PhpOffice\PhpWord\IOFactory::createWriter($newPhpWord, 'PDF');
        $writer->save($outputFile);
    
        return $outputFile;
    }
        */
    
/*
bonne convertion pour exel ancien model
    private function convertExcelToPdf($filePath)
    {
        $storagePath = storage_path('app/public/archives/');
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0777, true);
        }
        $NombrePageExtrait=100;
        $outputFile = $storagePath . pathinfo($filePath, PATHINFO_FILENAME) . '.pdf';
    
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
        $newSpreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $newSheet = $newSpreadsheet->getActiveSheet();
    
        $sheet = $spreadsheet->getActiveSheet();
        $highestColumn = $sheet->getHighestColumn();
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
    
        // Copier les 50 premières lignes
        for ($row = 1; $row <= min($NombrePageExtrait, $sheet->getHighestRow()); $row++) {
            for ($col = 1; $col <= $highestColumnIndex; $col++) {
                $cell = $sheet->getCellByColumnAndRow($col, $row);
                $newSheet->setCellValueByColumnAndRow($col, $row, $cell->getValue());
            }
        }
    
        // Convertir en PDF
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf($newSpreadsheet);
        $writer->save($outputFile);
    
        return $outputFile;
    }
   */ 


    

   public function processLargeTxtFile($filePath)
   {
       $chunkSize = 100;   // Nombre de mots par chunk
       $batchSize = 500;   // Nombre de chunks par batch
       $buffer = '';       // Stocke temporairement les mots
       $batch = [];        // Stocke les chunks pour le batch
       $wordCount = 0;     // Compteur de mots
   
       if (!file_exists($filePath)) {
           return "Fichier introuvable.";
       }
   
       $handle = fopen($filePath, "r");
       if (!$handle) {
           return "Impossible d'ouvrir le fichier.";
       }
   
       while (($line = fgets($handle)) !== false) {
           // Découper la ligne en mots
           $words = preg_split('/\s+/', trim($line)); 
           
           foreach ($words as $word) {
               if ($word === '') continue; // Ignorer les entrées vides
   
               $buffer .= $word . ' ';
               $wordCount++;
   
               // Quand un chunk est complet, l'ajouter au batch
               if ($wordCount % $chunkSize === 0) {
                   $batch[] = trim($buffer);
                   $buffer = '';
               }
   
               // Quand le batch atteint batchSize, le traiter
               if (count($batch) === $batchSize) {
                   $this->addToBuffer(implode(' ', $batch));
                   $batch = []; // Réinitialiser le batch
               }
           }
       }
   
       // Ajouter les données restantes
       if (!empty($batch)) {
           $this->addToBuffer(implode(' ', $batch));
       }
       if (!empty($buffer)) {
           $this->addToBuffer(trim($buffer));
       }
   
       fclose($handle);
       return "Traitement terminé.";
   }
   

 

    private function processPdfChunked(string $path)//extration par page pdf sans tout charger le document pdf en memoire avec pdftotext
    {

        $pageNumber = 1;
        $buffer = '';
        $NombrePageExtrait=50;
        while($pageNumber<=$NombrePageExtrait) {

            try {
                $output = shell_exec("pdftotext -f $pageNumber -l $pageNumber $path - 2>&1");
                
                $buffer .= $output;
                
                if(strlen($buffer) >= self::FILE_CHUNK_SIZE || $pageNumber % self::PDF_PAGE_LIMIT === 0) {
                    $this->addToBuffer($buffer);
                    $buffer = '';
                }
                
                $pageNumber++;
                $this->processedChunks-=1;
                unset($output);
                gc_collect_cycles();
                
            } catch (\Exception $e) {
                break;
            }
        }

        if(!empty($buffer)) {
            $this->addToBuffer($buffer);
        }
    }


    private function addToBuffer(string $content)
    {
        $this->buffer .= $content;
        $this->processedChunks++;

        if($this->processedChunks >= self::DB_BATCH_SIZE) {
            $this->flushBufferToDB();
            $this->processedChunks = 0;
        }
    }

    private function flushBufferToDB()
    {
        if(!empty($this->buffer)) {
            try {
                $encoding = mb_detect_encoding($this->buffer, ['UTF-8', 'ISO-8859-1', 'Windows-1252', 'ASCII'], true);
                if ($encoding !== 'UTF-8') {
                    $this->buffer = mb_convert_encoding($this->buffer, 'UTF-8', $encoding);
                }
                $document = Document::find($this->document->id);
                $data = collect([
                    'content' =>  mb_convert_encoding($this->buffer, 'UTF-8', 'auto'),
                    'updated_at' => now(),
                    ]);
    
                    // Mise à jour
                    $document->update($data->toArray());  
                
                $this->buffer = '';
            } catch (Exception $e) {
                \Log::error("Database update error: " . $e->getMessage());
                throw $e;
            }
        }
    }

    private function finalizeContent()
    {
        $this->flushBufferToDB();

        if(!empty($this->mot_cle)) {
            $escapedContent = DB::getPdo()->quote(' ' . $this->mot_cle);
            DB::table('documents')
                ->where('id', $this->document->id)
                ->update([
                    'content' => DB::raw("CONCAT(COALESCE(content, ''), $escapedContent)"),
                    'updated_at' => now()
                ]);
        }

        unset($this->buffer);
        gc_collect_cycles();
    }



    public function failed(Exception $exception)
    {
        $this->document->update([
            'status' => 'failed',
            'error_message' => substr($exception->getMessage(), 0, 255)
        ]);
    }

    public function batchSize(): int { return 1000; }
    public function retryUntil() { return now()->addMinutes(30); }
}