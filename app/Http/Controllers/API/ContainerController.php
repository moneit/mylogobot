<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Container;
use App\Services\SvgContainerService;

class ContainerController extends Controller
{
    public function index(Request $request)
    {
        $containersList = Container::where('filled', $request->get('filled'))
            ->get();

        return $this->response([
            'status' => 'success',
            'payload' => [
                'list' => $containersList,
            ],
        ], 200);
    }

    public function data(Request $request)
    {
        try {
            $service = new SvgContainerService($request->get('id'));
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
                'shapes' => $service->getShapes(),
                'viewBox' => $service->getViewBox(),
            ],
        ], 200);
    }
}
