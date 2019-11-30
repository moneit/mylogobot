<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\FontRecommendationsTypographyLogo\StoreRequest;
use App\FontRecommendationsTypographyLogo;

class FontRecommendationsTypographyLogoController extends Controller
{
    public function store(StoreRequest $request)
    {
        $companyNameFontId = $request->get('company_name_font_id');
        $sloganFontId = $request->get('slogan_font_id');

        $exist = FontRecommendationsTypographyLogo::where('company_name_font_id', '=', $companyNameFontId)
            ->where('slogan_font_id', '=', $sloganFontId)
            ->first();

        if (empty($exist)) {
            $fontRecommendationsTypographyLogo = new FontRecommendationsTypographyLogo;

            $fontRecommendationsTypographyLogo->company_name_font_id = $request->get('company_name_font_id');
            $fontRecommendationsTypographyLogo->slogan_font_id = $request->get('slogan_font_id');

            $fontRecommendationsTypographyLogo->save();
        } else {
            $fontRecommendationsTypographyLogo = $exist;
        }

        return $this->response([
            'status' => 'success',
            'payload' => [
                'fontRecommendationsTypographyLogo' => $fontRecommendationsTypographyLogo,
            ],
        ], 200);
    }
}
