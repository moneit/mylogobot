<?php

namespace App\Http\Controllers\API;

use App\Logo;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\FreeDownloadRequest;
use App\FreeDownload;
use App\Services\FreeJpgService;

class FreeDownloadController extends Controller
{
    public function create(FreeDownloadRequest $request, FreeJpgService $freeJpgService)
    {
        try {
            $logoId = $request->get('logoId');

            $model = FreeDownload::firstOrCreate([
                'user_id' => \Auth::id(),
                'logo_id' => $logoId,
            ]);
            $model->count = $model->count + 1;
            if (empty($model->file_id)) {
                $logo = Logo::findOrFail($logoId);

                $model->file_id = $freeJpgService->generateFreeJpgFile($logo);
            }

            $model->save();

            return $this->response([
                'status' => 'success',
                'payload' => [
                    'jpgLink' => $freeJpgService->getFreeJpgLink($model->file_id),
                    'downloadLink' => $freeJpgService->generateFreeJpgDownloadLink($model->file_id)
                ],
            ], 200);
        } catch (\Exception $e) {

            return $this->response([
                'status' => 'failure',
                'payload' => [
                    'message' => $e->getMessage(),
                ],
            ], 200);
        }
    }
}
