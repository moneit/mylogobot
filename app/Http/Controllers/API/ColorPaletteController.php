<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ColorPalette\StoreRequest;
use App\ColorPalette;

class ColorPaletteController extends Controller
{
    public function store(StoreRequest $request)
    {
        // check if exists in DB
        $colorId = $request->get('color_id');
        $paletteId = $request->get('palette_id');

        $exist = ColorPalette::where('color_id', '=', $colorId)
            ->where('palette_id', '=', $paletteId)
            ->first();

        if (empty($exist)) {
            $colorPalette = new ColorPalette;

            $colorPalette->color_id = $colorId;
            $colorPalette->palette_id = $paletteId;

            $colorPalette->save();
        } else {
            $colorPalette = $exist;
        }

        return $this->response([
            'status' => 'success',
            'payload' => [
                'colorPalette' => $colorPalette,
            ],
        ], 200);
    }
}
