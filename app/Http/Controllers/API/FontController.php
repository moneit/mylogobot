<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SvgFontService;
use App\Font;

class FontController extends Controller
{
    public function paths(Request $request)
    {
        try {
            $service = new SvgFontService($request->get('fontId'));

            $string = $request->get('string');
            $paths = [];

            if (!empty($string)) {
                switch($request->get('capitalization')) {
                    case 'uppercase':
                        $string = strtoupper($string);
                        break;
                    case 'lowercase':
                        $string = strtolower($string);
                        break;
                    case 'capitalize':
                        $string = ucwords($string);
                        break;
                }
                $paths = $service->getPathsByString($string);
            }
        } catch (\Exception $e) {
            return $this->response([
                'status' => 'error',
                'payload' => [
                    'message' => $e->getMessage()
                ]
            ], 500);
        }

        return $this->response([
            'status' => 'success',
            'payload' => [
                'paths' => $paths,
            ],
        ], 200);
    }

    public function bounds(Request $request)
    {
        $service = new SvgFontService($request->get('fontId'));

        return $this->response([
            'status' => 'success',
            'payload' => [
                'bounds' => $service->getBounds(),
            ],
        ], 200);
    }

    public function horizAdvX(Request $request)
    {
        $service = new SvgFontService($request->get('fontId'));

        return $this->response([
            'status' => 'success',
            'payload' => [
                'globalAdvX' => $service->getGlobalHorizAdvX(),
            ],
        ], 200);
    }

    public function index()
    {
        return $this->response([
            'status' => 'success',
            'payload' => [
                'categories' => Font::all()->groupBy('category'),
            ],
        ], 200);
    }
}
