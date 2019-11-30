<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Color;
use App\ColorCategory;
use App\Palette;
use App\Http\Responses\Transformers\ColorCategoriesTransformer;

class ColorController extends Controller
{
    public function index()
    {
        return $this->response([
            'status' => 'success',
            'payload' => [
                'categories' => Color::all()->keyBy('name'),
            ],
        ], 200);
    }

    public function palette(Request $request)
    {
        $toneId = $request->get('toneId');
        $options = Palette::select(['bg_color', 'company_name_color', 'slogan_color', 'symbol_color'])
            ->whereHas('tones', function($q) use ($toneId) {
                $q->where('id', '=', $toneId);
            })
            ->get();


        return $this->response([
            'status' => 'success',
            'payload' => [
                'options' => $options,
            ],
        ], 200);
    }

    public function getCategories()
    {
        $colorCategories = ColorCategory::all();

        return $this->response([
            'status' => 'success',
            'payload' => ColorCategoriesTransformer::transform($colorCategories),
        ], 200);
    }
}
