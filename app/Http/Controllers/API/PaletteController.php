<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Palette\StoreRequest;
use App\Palette;

class PaletteController extends Controller
{
    public function store(StoreRequest $request)
    {
        // check if exists in DB
        $bgColor = $request->get('bg_color');
        $companyNameColor = $request->get('company_name_color');
        $sloganColor = $request->get('slogan_color');
        $symbolColor = $request->get('symbol_color');

        $exist = Palette::where('bg_color', '=', $bgColor)
            ->where('company_name_color', '=', $companyNameColor)
            ->where('slogan_color', '=', $sloganColor)
            ->where('symbol_color', '=', $symbolColor)
            ->first();

        if (empty($exist)) {
            $palette = new Palette;

            $palette->bg_color = $bgColor;
            $palette->company_name_color = $companyNameColor;
            $palette->slogan_color = $sloganColor;
            $palette->symbol_color = $symbolColor;

            $palette->save();
        } else {
            $palette = $exist;
        }

        return $this->response([
            'status' => 'success',
            'payload' => [
                'palette' => $palette,
            ],
        ], 200);
    }
}
