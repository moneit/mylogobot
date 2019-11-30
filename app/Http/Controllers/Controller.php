<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Services\StringEncodeDecodeService;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function response($content = '', $status = 200, array $headers = [])
    {
//        return response(StringEncodeDecodeService::encode(json_encode($content)), $status, $headers);
        return response($content, $status, $headers);
    }
}
