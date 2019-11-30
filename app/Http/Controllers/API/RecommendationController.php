<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Recommendation\RecommendationService;
use App\Services\Cortical\Service as CorticalService;
use App\Services\MyNLPService;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\EachPromise;
use App\RecommendationTrack;
use App\RecommendationTrackKeywords;
use App\User;

class RecommendationController extends Controller
{
    /**
     * @var RecommendationService
     */
    private $recommendationService;

    /**
     * ConversationController constructor.
     *
     * @param RecommendationService $recommendationService
     */
    public function __construct(RecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }

    public function getLogos(Request $request)
    {
        try {
            $companyName = $request->get('companyName') ?? '';
            $companyDetails = $request->get('companyDetails') ?? ''; // this is keywords now
            $slogan = $request->get('slogan') ?? '';
            $layouts = $request->get('layout') ?? [];
            $colorIds = $request->get('paletteCategoriesIds', []);

            $apiToken = $request->get('api_token', '');
            $user = User::where('api_token', $apiToken)->first();
            if (!is_null($user)) {
                $userId = $user->id;
            } else {
                $userId = null;
            }

            $track = RecommendationTrack::create([
                'company_name' => $companyName, 'slogan' => $slogan, 'details' => $companyDetails, 'user_id' => $userId
            ]);
            // todo: store color and layout into track table as well

//            $seeds = $this->recommendationService->GetKeyWordsFromNameAndDescription($companyName, $companyDetails);
            $seeds = MyNLPService::getSeedsFromWords(explode(' ', $companyDetails));

            $count = 6;
            $logos = [];
            if (count($seeds) > 0) {
                $client = new Client();
                $promises = (function () use ($client, $count, $layouts, $companyName, $slogan, $seeds, $colorIds) {
                    $i = 0;
                    while($i < $count) {
                        if (count($layouts) > 0) {
                            $rand = rand(0, count($layouts) - 1);
                            $layout = $layouts[$rand];
                        } else {
                            $layout = '';
                        }
                        $i++;

                        yield $this->recommendationService->getRecommendedLogo($companyName, $slogan, $seeds, $layout, $colorIds, $client);
                    }
                })();

                $eachPromise = new EachPromise($promises, [
                    // how many concurrency we are use
                    'concurrency' => $count,
                    'fulfilled' => function ($recommendedLogo) use (&$logos) {
                        $logos[] = $recommendedLogo;
                    },
                    'rejected' => function ($reason) {
                        // handle promise rejected here
                        \Log::error('rejected', [$reason]);
                    }
                ]);

                $eachPromise->promise()->wait();

                if (count($logos) < $count) {
                    return $this->response([
                        'status' => 'failure',
                        'payload' => [
                            'message' => 'Sorry, bot could not generate logos according to your input. Please try to update company description.',
                        ],
                    ], 200);
                }
            } else {
                return $this->response([
                    'status' => 'failure',
                    'payload' => [
                        'message' => 'Sorry, bot could not generate logos due to lack of information. Please try to re-input company details.',
                    ],
                ], 200);
            }

            return $this->response([
                'status' => 'success',
                'payload' => [
                    'logos' => $logos,
                ],
            ], 200);
        } catch(\Exception $e) {
            return $this->response([
                'status' => 'failure',
                'payload' => [
                    'message' => $e->getMessage(),
                ],
            ], 200);
        }
    }
}
