<?php

namespace App\Livewire;

use App\Models\ActivityLog;
use App\Models\Document;
use App\Models\folder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModalVerrou extends Component
{
    public string $unlockCode = '';
    public bool $accessGranted = false;
    public $modelEncours;
    public $modelencourName;
    public function mount($id, $model){
        if($model=="folder"){
        $folder = folder::find($id);
        if($folder){
            $this->modelEncours=$folder;
            if($folder['verrouille']==true){ //verifie si le dossier contient un verrouillage si oui on affiche le modal de demande code d'acces
                $this->accessGranted=true;
                $this->modelencourName=$folder['name'];
            }else{
                $this->accessGranted=false;
            }  
        }
        }
        if($model=="document"){
            $document = Document::find($id);
            if($document){
                $this->modelEncours=$document;
                if($document['verrouille']==true){ //verifie si le dossier contient un verrouillage si oui on affiche le modal de demande code d'acces
                    $this->accessGranted=true;
                    $this->modelencourName=$document['nom'];
                }else{
                    $this->accessGranted=false;
                }
                
            }
        }
    }
    public function verifyCode()
    {
        if (Hash::check($this->unlockCode, $this->modelEncours->code_verrou)) {
            $this->accessGranted = false;
            $this->dispatch('checkAccess') ;
            ActivityLog::create([
                'action' => '✔️Dévérouillage pour lecture',
                'description' => $this->modelencourName,
                'icon' => '✔️' ,
                'user_id' => Auth::id(),
                'confidentiel' => false,
            ]);        
        } else {
            $this->addError('unlockCode', 'Code incorrect.');
            ActivityLog::create([
                'action' => '❌Echec dévérouillage pour lecture',
                'description' => $this->modelencourName,
                'icon' => '❌' ,
                'user_id' => Auth::id(),
                'confidentiel' => false,
            ]);
        }
    }
    public function render()
    {
        return view('livewire.modal-verrou');
    }
}