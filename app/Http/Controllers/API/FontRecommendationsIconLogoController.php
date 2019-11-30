<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\FontRecommendationsIconLogo\StoreRequest;
use App\FontRecommendationsIconLogo;

class FontRecommendationsIconLogoController extends Controller
{
    public function store(StoreRequest $request)
    {
        $companyNameFontId = $request->get('company_name_font_id');
        $sloganFontId = $request->get('slogan_font_id');

        $exist = FontRecommendationsIconLogo::where('company_name_font_id', '=', $companyNameFontId)
            ->where('slogan_font_id', '=', $sloganFontId)
            ->first();

        if (empty($exist)) {
            $fontRecommendationsIconLogo = new FontRecommendationsIconLogo;

            $fontRecommendationsIconLogo->company_name_font_id = $request->get('company_name_font_id');
            $fontRecommendationsIconLogo->slogan_font_id = $request->get('slogan_font_id');

            $fontRecommendationsIconLogo->save();
        } else {
            $fontRecommendationsIconLogo = $exist;
        }


        return $this->response([
            'status' => 'success',
            'payload' => [
                'fontRecommendationsIconLogo' => $fontRecommendationsIconLogo,
            ],
        ], 200);
    }
}
