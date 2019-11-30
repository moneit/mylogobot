<?php

namespace App\Services\Cortical;

use App\Services\Cortical\Commands\GetKeyWordsFromDescriptionCommand;
use Illuminate\Support\Str;

class Service
{
    /**
     * @param $description
     *
     * @return mixed
     */
    public function getKeyWordsFromDescription($description)
    {
        try {
            $command = new GetKeyWordsFromDescriptionCommand($description);
            $response = $command->execute();

            $keyWords = $response['payload'];

            $keyWords = array_map(function($plural) {
                return Str::singular($plural);
            }, $keyWords);
        } catch (\Exception $e) {
            // \Log::error('Exception occurred while fetching data from Cortical', $e->getMessage());
        }

        if (empty($keyWords) || ! is_array($keyWords)) {
            $keyWords = array_map(function($segment) {
                return strtolower($segment);
            }, explode(' ', $description));
        }

        return $keyWords;
    }
}