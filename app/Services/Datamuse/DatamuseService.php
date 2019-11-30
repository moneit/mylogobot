<?php

namespace App\Services\Datamuse;

use App\Services\Datamuse\commands\GetNounsFromCompanyDescriptionCommand;
use App\Services\Datamuse\commands\GetAdjectiveDescribesNounCommand;
use App\Services\Datamuse\commands\GetNounFromCompanyNameAndTopicsCommand;

class DatamuseService
{
    /**
     * @param string $name
     * @param string $details
     *
     * @return array
     */
    public function getSeedsFromCompanyNameAndDetails($name, $details)
    {
        $seeds = [];

        $name = strtolower($name);
        $details = strtolower($details);

        $nameSegments = explode(' ', $name);
        $removables = ['A', 'a', 'The', 'the', 'We', 'we', 'He', 'he', 'She', 'she', 'They', 'they', 'I', 'am', 'is', 'was', 'are', 'were', 'company'];

        if (count($nameSegments) > 1) { // when company name has white space in it (more than 2 words)
            if (! $details) { // when user does not input details, company name comes to seeds
                $seeds = $nameSegments;
            } else {
                $detailsSegments = explode(' ', $details);

                // remove no meaning words
                $nameSegments = array_diff($nameSegments, $removables);
                $detailsSegments = array_diff($detailsSegments, $removables);

                $nameDescriptionIntersected = array_intersect($nameSegments, $detailsSegments);
                if (count($nameDescriptionIntersected) > 0) { // if any word appears in both name and description
                    $seeds = array_values($nameDescriptionIntersected);
                } else {
                    try {
                        $command = new GetNounsFromCompanyDescriptionCommand($details);
                        $response = $command->execute();

                        $words = [];
                        foreach($response['payload'] as $datum) {
                            $words[] = $datum->word;
                        }
                        $intersected = array_intersect($nameSegments, $words);
                        if (count($intersected) > 0) {
                            $seeds = array_values($intersected);
                        } else {
                            $seeds = $nameSegments;
                        }
                    } catch (\Exception $e) {
                        $seeds = $nameSegments;
                    }
                }
            }
        } else {
            if (! $details) { // when user does not input details return []

            } else {
                try {
                    $command = new GetNounsFromCompanyDescriptionCommand($details);
                    $response = $command->execute();

                    $payload = $response['payload'];
                    $count = 0;
                    $i = 0;
                    while ($count < 5 && $i < count($payload) - 1) {
                        if (in_array('n', $payload[$i]->tags)) {
                            $word = $response['payload'][$i]->word;
                            if (strpos($word, ' ') === false) {
                                $seeds[] = $word;
                            }
                        }
                        $i++;
                    }
                } catch (\Exception $e) {
                    // return []
                }
            }
        }

        try {
            $command = new GetNounFromCompanyNameAndTopicsCommand($name, $seeds);
            $response = $command->execute();

            if (count($response['payload']) > 0) {
                $seeds[] = $response['payload'][0]->word;
            }
        } catch(\Exception $e) {
            // return $seeds;
        }

        return $seeds;
    }

    /**
     * @param string $noun
     *
     * @return array
     */
    public function getAdjDescribesNoun($noun)
    {
        $command = new GetAdjectiveDescribesNounCommand($noun);
        $response = $command->execute();

        $rand = rand(0, 10);

        if (count($response['payload']) > $rand) {
            $adj = $response['payload'][$rand]->word;
        } else if (count($response['payload']) > 0) {
            $adj = $response['payload'][0]->word;
        } else {
            $adj = 'best';
        }

        return $adj;
    }
}