<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Meilisearch\Client;

class SetupMeilisearchStopWords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meilisearch:setup-stopwords';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set up stop words for Meilisearch indexes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));

        // Source: https://github.com/stopwords-iso/stopwords-fr
        $stopWords = [
            'a', 'à', 'â', 'abord', 'afin', 'ah', 'ai', 'aie', 'aient', 'aies', 'ailleurs', 'ainsi', 'ait', 'allaient', 'allo', 'allons', 'allô', 'alors', 'après', 'as', 'assez', 'attendu', 'au', 'aucun', 'aucune', 'aucuns', 'aujourd', 'aujourd\'hui', 'auquel', 'aura', 'aurai', 'auraient', 'aurais', 'aurait', 'auras', 'aurez', 'auriez', 'aurions', 'aurons', 'auront', 'aussi', 'autre', 'autres', 'autrui', 'aux', 'auxquelles', 'auxquels', 'avaient', 'avais', 'avait', 'avant', 'avec', 'avez', 'aviez', 'avions', 'avoir', 'avons', 'ayant', 'ayez', 'ayons', 'b', 'bah', 'bas', 'beaucoup', 'bien', 'bigre', 'bon', 'boum', 'bravo', 'brrr', 'c', 'car', 'ce', 'ceci', 'cela', 'celà', 'celle', 'celle-ci', 'celle-là', 'celles', 'celles-ci', 'celles-là', 'celui', 'celui-ci', 'celui-là', 'cent', 'cependant', 'certain', 'certaine', 'certaines', 'certains', 'certes', 'ces', 'cet', 'cette', 'ceux', 'ceux-ci', 'ceux-là', 'chacun', 'chacune', 'chaque', 'cher', 'chère', 'chères', 'chers', 'chez', 'chiche', 'chut', 'ci', 'cinq', 'cinquante', 'cinquantième', 'cinquième', 'clac', 'clic', 'combien', 'comme', 'comment', 'compris', 'concernant', 'contre', 'couic', 'crac', 'd', 'da', 'dans', 'de', 'debout', 'dedans', 'dehors', 'delà', 'depuis', 'dernier', 'dernière', 'derrière', 'des', 'dès', 'désormais', 'desquelles', 'desquels', 'dessous', 'dessus', 'deux', 'deuxième', 'deuxièmement', 'devant', 'devers', 'devra', 'devrait', 'différent', 'différente', 'différentes', 'différents', 'dire', 'divers', 'diverse', 'diverses', 'dix', 'dix-huit', 'dixième', 'dix-neuf', 'dix-sept', 'doit', 'doivent', 'donc', 'dont', 'douze', 'douzième', 'dring', 'droite', 'du', 'dû', 'duquel', 'durant', 'e', 'eh', 'elle', 'elle-même', 'elles', 'elles-mêmes', 'en', 'encore', 'enfin', 'entre', 'envers', 'environ', 'es', 'ès', 'est', 'et', 'etant', 'étant', 'etc', 'été', 'étée', 'étées', 'étées', 'étés', 'êtes', 'être', 'eu', 'eue', 'eues', 'euh', 'eurent', 'eus', 'eusse', 'eussent', 'eusses', 'eussiez', 'eussions', 'eut', 'eût', 'eux', 'eux-mêmes', 'excepté', 'f', 'façon', 'fais', 'faisaient', 'faisant', 'fait', 'faites', 'feront', 'fi', 'flac', 'floc', 'fois', 'font', 'force', 'furent', 'fus', 'fusse', 'fussent', 'fusses', 'fussiez', 'fussions', 'fut', 'fût', 'g', 'gens', 'h', 'ha', 'haut', 'hé', 'hein', 'hélas', 'hem', 'hep', 'hi', 'ho', 'holà', 'hop', 'hormis', 'hors', 'hou', 'houp', 'hue', 'hui', 'huit', 'huitième', 'hum', 'hurrah', 'i', 'ici', 'il', 'ils', 'importe', 'j', 'je', 'jusqu', 'jusque', 'k', 'l', 'la', 'là', 'laquelle', 'las', 'le', 'lequel', 'les', 'lès', 'lesquelles', 'lesquels', 'leur', 'leurs', 'longtemps', 'lors', 'lorsque', 'lui', 'lui-même', 'm', 'ma', 'maint', 'maintenant', 'mais', 'malgré', 'me', 'même', 'mêmes', 'merci', 'mes', 'mien', 'mienne', 'miennes', 'miens', 'mille', 'mince', 'moi', 'moi-même', 'moins', 'mon', 'mot', 'moyennant', 'n', 'na', 'ne', 'néanmoins', 'neuf', 'neuvième', 'ni', 'nombreuses', 'nombreux', 'non', 'nos', 'notre', 'nôtre', 'nôtres', 'nous', 'nous-mêmes', 'nul', 'o', 'ô', 'oh', 'ohé', 'olé', 'ollé', 'on', 'ont', 'onze', 'onzième', 'ore', 'ou', 'où', 'ouf', 'ouias', 'oust', 'ouste', 'outre', 'p', 'paf', 'pan', 'par', 'parce', 'parmi', 'partant', 'particulier', 'particulière', 'particulièrement', 'pas', 'passé', 'pendant', 'personne', 'peu', 'peut', 'peuvent', 'peux', 'pff', 'pfft', 'pfut', 'pif', 'pis', 'plaf', 'plein', 'plouf', 'plupart', 'plus', 'plusieurs', 'plutôt', 'pouah', 'pour', 'pourquoi', 'pourtant', 'premier', 'première', 'premièrement', 'près', 'proche', 'psitt', 'pu', 'puis', 'puisque', 'q', 'qu', 'quand', 'quant', 'quanta', 'quant-à-soi', 'quarante', 'quatorze', 'quatre', 'quatre-vingt', 'quatrième', 'quatrièmement', 'que', 'quel', 'quelconque', 'quelle', 'quelles', 'quelqu\'un', 'quelque', 'quelques', 'quels', 'qui', 'quiconque', 'quinze', 'quoi', 'quoique', 'r', 'revoici', 'revoilà', 'rien', 's', 'sa', 'sacrebleu', 'sans', 'sapristi', 'sauf', 'se', 'seize', 'selon', 'sept', 'septième', 'sera', 'serai', 'seraient', 'serais', 'serait', 'seras', 'serez', 'seriez', 'serions', 'serons', 'seront', 'ses', 'seulement', 'si', 'sien', 'sienne', 'siennes', 'siens', 'sinon', 'six', 'sixième', 'soi', 'soi-même', 'soient', 'sois', 'soit', 'soixante', 'sommes', 'son', 'sont', 'sous', 'stop', 'suis', 'suivant', 'sur', 'surtout', 't', 'ta', 'tac', 'tandis', 'tant', 'te', 'té', 'tel', 'telle', 'telles', 'tels', 'tenant', 'tes', 'tic', 'tien', 'tienne', 'tiennes', 'tiens', 'toc', 'toi', 'toi-même', 'ton', 'sont', 'tous', 'tout', 'toute', 'toutes', 'treize', 'trente', 'très', 'trois', 'troisième', 'troisièmement', 'trop', 'trouvé', 'tsoin', 'tsouin', 'tu', 'u', 'un', 'une', 'unes', 'uns', 'v', 'va', 'vais', 'vas', 'vé', 'vers', 'via', 'vif', 'vifs', 'vingt', 'vivat', 'vive', 'vives', 'voici', 'voilà', 'vont', 'vos', 'votre', 'vôtre', 'vôtres', 'vous', 'vous-mêmes', 'vu', 'w', 'x', 'y', 'z', 'zut', 'alors', 'au', 'aucuns', 'aussi', 'autre', 'avant', 'avec', 'avoir', 'bon', 'car', 'ce', 'cela', 'ces', 'ceux', 'chaque', 'ci', 'comme', 'comment', 'dans', 'des', 'du', 'dedans', 'dehors', 'depuis', 'devrait', 'doit', 'donc', 'dos', 'début', 'elle', 'elles', 'en', 'encore', 'essai', 'est', 'et', 'eu', 'fait', 'faites', 'fois', 'font', 'hors', 'ici', 'il', 'ils', 'je', 'juste', 'la', 'le', 'les', 'leur', 'là', 'ma', 'maintenant', 'mais', 'mes', 'mine', 'moins', 'mon', 'mot', 'même', 'ni', 'nommés', 'notre', 'nous', 'ou', 'où', 'par', 'parce', 'pas', 'peut', 'peu', 'plupart', 'pour', 'pourquoi', 'quand', 'que', 'quel', 'quelle', 'quelles', 'quels', 'qui', 'sa', 'sans', 'ses', 'seulement', 'si', 'sien', 'son', 'sont', 'sous', 'soyez', 'sujet', 'sur', 'ta', 'tandis', 'tellement', 'tels', 'tes', 'ton', 'tous', 'tout', 'trop', 'très', 'tu', 'voient', 'vont', 'votre', 'vous', 'vu', 'ça', 'étaient', 'état', 'étions', 'été', 'être'
        ];

        $this->info('Setting up stop words for [documents] index...');
        try {
            $documentsIndex = $client->index('documents');
            $documentsIndex->updateStopWords($stopWords);
            $this->info('Successfully updated stop words for [documents].');
        } catch (\Exception $e) {
            $this->error('Failed to update stop words for [documents]: ' . $e->getMessage());
        }

        $this->info('Setting up stop words for [folders] index...');
        try {
            $foldersIndex = $client->index('folders');
            $foldersIndex->updateStopWords($stopWords);
            $this->info('Successfully updated stop words for [folders].');
        } catch (\Exception $e) {
            $this->error('Failed to update stop words for [folders]: ' . $e->getMessage());
        }

        return 0;
    }
}