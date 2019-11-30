<?php

namespace App\Services\Google\Language;

use Google\Cloud\Language\LanguageClient;
use Illuminate\Support\Str;

class Service
{
    /**
     * @var LanguageClient
     */
    private $client;

    /**
     * Service constructor.
     */
    public function __construct()
    {
        $this->client = new LanguageClient([
            'keyFilePath' => env('PATH_TO_GOOGLE_SERVICE_ACCOUNT_KEY_FILE')
        ]);
    }

    /**
     * get 100 seeds
     *
     * @param $str
     *
     * @return array
     */
    public function getSeeds($str)
    {
        $annotation = $this->client->analyzeEntities($str);
        $entities = $annotation->entities();

        $seeds = [];
        if (count($entities) > 0) {
            foreach($entities as $entity) {
                $seeds[] = [
                    'phrase' => Str::singular($entity['name']) ?? $entity['name'],
                    'ratio' => $entity['salience'],
                ];
            }
        }

        return $seeds;
    }
}