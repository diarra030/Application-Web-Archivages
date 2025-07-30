<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Meilisearch\Client;

class SetupMeilisearchSynonyms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meilisearch:setup-synonyms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set up synonyms for Meilisearch indexes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));

        $synonyms = [
            'rh' => ['ressources humaines'],
            'compta' => ['comptabilité'],
            'it' => ['informatique', 'support technique'],
            'kpi' => ['indicateur de performance'],
            'doc' => ['document'],
            'fact' => ['facture'],
        ];

        $this->info('Setting up synonyms for [documents] index...');
        try {
            $documentsIndex = $client->index('documents');
            $documentsIndex->updateSynonyms($synonyms);
            $this->info('Successfully updated synonyms for [documents].');
        } catch (\Exception $e) {
            $this->error('Failed to update synonyms for [documents]: ' . $e->getMessage());
        }

        $this->info('Setting up synonyms for [folders] index...');
        try {
            $foldersIndex = $client->index('folders');
            $foldersIndex->updateSynonyms($synonyms);
            $this->info('Successfully updated synonyms for [folders].');
        } catch (\Exception $e) {
            $this->error('Failed to update synonyms for [folders]: ' . $e->getMessage());
        }

        return 0;
    }
}
