<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Meilisearch\Client;

class SetupMeilisearchRankingRules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meilisearch:setup-ranking-rules';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set custom ranking rules for Meilisearch indexes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));

        $this->info('Setting up ranking rules for [documents] index...');
        
        try {
            $documentsIndex = $client->index('documents');
            $documentsIndex->updateRankingRules([
                'words',
                'attribute',
                'proximity',
                'sort',
                'typo',
                'exactness',
                'created_at:desc',
            ]);
            $this->info('Successfully updated ranking rules for [documents].');
        } catch (\Exception $e) {
            $this->error('Failed to update ranking rules for [documents]: ' . $e->getMessage());
        }

        $this->info('Setting up ranking rules for [folders] index...');
        try {
            $foldersIndex = $client->index('folders');
            $foldersIndex->updateRankingRules([
                'words',
                'attribute',
                'proximity',
                'sort',
                'typo',
                'exactness',
                'created_at:desc',
            ]);
            $this->info('Successfully updated ranking rules for [folders].');
        } catch (\Exception $e) {
            $this->error('Failed to update ranking rules for [folders]: ' . $e->getMessage());
        }

        return 0;
    }
}
