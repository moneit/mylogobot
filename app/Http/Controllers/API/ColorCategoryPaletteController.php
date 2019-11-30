<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\ColorCategoryPalette\StoreRequest;
use App\ColorCategoryPalette;

class ColorCategoryPaletteController extends Controller
{
    public function store(StoreRequest $request)
    {
        // check if exists in DB
        $colorCategoryId = $request->get('color_category_id');
        $paletteId = $request->get('palette_id');

        $exist = ColorCategoryPalette::where('color_category_id', '=', $colorCategoryId)
            ->where('palette_id', '=', $paletteId)
            ->first();

        if (empty($exist)) {
            $colorCategoryPalette = new ColorCategoryPalette;

            $colorCategoryPalette->color_category_id = $colorCategoryId;
            $colorCategoryPalette->palette_id = $paletteId;

            $colorCategoryPalette->save();
        } else {
            $colorCategoryPalette = $exist;
        }

        return $this->response([
            'status' => 'success',
            'payload' => [
                'colorCategoryPalette' => $colorCategoryPalette,
            ],
        ], 200);
    }
}
