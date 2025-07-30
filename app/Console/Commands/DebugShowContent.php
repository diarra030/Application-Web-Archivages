<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Document;

class DebugShowContent extends Command
{
    protected $signature = 'debug:show-content';
    protected $description = 'Displays the extracted content of a specific document.';

    public function handle()
    {
        $results = Document::search('facture')->raw();

        $this->info(json_encode($results, JSON_PRETTY_PRINT));

        return 0;
    }
}
