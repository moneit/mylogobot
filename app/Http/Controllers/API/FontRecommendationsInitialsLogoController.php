<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\FontRecommendationsInitialsLogo\StoreRequest;
use App\FontRecommendationsInitialsLogo;

class FontRecommendationsInitialsLogoController extends Controller
{
    public function store(StoreRequest $request)
    {
        $companyNameFontId = $request->get('company_name_font_id');
        $sloganFontId = $request->get('slogan_font_id');
        $initialsFontId = $request->get('initials_font_id');

        $exist = FontRecommendationsInitialsLogo::where('company_name_font_id', '=', $companyNameFontId)
            ->where('slogan_font_id', '=', $sloganFontId)
            ->where('initials_font_id', '=', $initialsFontId)
            ->first();

        if (empty($exist)) {
            $fontRecommendationsInitialsLogo = new FontRecommendationsInitialsLogo;

            $fontRecommendationsInitialsLogo->company_name_font_id = $request->get('company_name_font_id');
            $fontRecommendationsInitialsLogo->slogan_font_id = $request->get('slogan_font_id');
            $fontRecommendationsInitialsLogo->initials_font_id = $request->get('initials_font_id');

            $fontRecommendationsInitialsLogo->save();
        } else {
            $fontRecommendationsInitialsLogo = $exist;
        }

        return $this->response([
            'status' => 'success',
            'payload' => [
                'fontRecommendationsInitialsLogo' => $fontRecommendationsInitialsLogo,
            ],
        ], 200);
    }
}
