<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SvgIconService;
use App\Services\TheNounProjectService;

class IconController extends Controller
{
    /**
     * @var string
     */
    private $cacheKey;

    /**
     * IconController constructor.
     */
    public function __construct()
    {
        $this->cacheKey = \Auth::id().'_icons';
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $result = TheNounProjectService::getData($request->get('search-input') ?? 'icon');

        if (! empty($result['body'])) {
            $ttl = 10; // clear after 10 min
            \Cache::put($this->cacheKey, json_encode($result['body']), $ttl);

            $result['body'] = array_map(function($icon) {
                return $icon['preview_url'];
            }, $result['body']);
        }

        return $this->response([
            'status' => 'success',
            'payload' => $result,
        ], 200);
    }

    public function getImagePaths(Request $request)
    {
        try {
            $previewUrl = $request->get('url');

            $icons = collect(json_decode(\Cache::get($this->cacheKey, '[]')))->pluck('icon_url', 'preview_url');
            $iconUrl = $icons[$previewUrl];

            $svgIconService = new SvgIconService(file_get_contents($iconUrl));
            $tags = $svgIconService->asXml();
            $bounds = $svgIconService->getBounds();

            $attr = [];
            foreach($svgIconService->getAttributes() as $key => $value) {
                $attr[$key] = (string)$value;
            }

        } catch (\Exception $e) {
            return $this->response([
                'status' => 'error',
                'payload' => [
                    'message' => $e->getMessage()
                ]
            ], 200);
        }

        return $this->response([
            'status' => 'success',
            'payload' => [
                'tags' => $tags,
                'iconBounds' => $bounds,
                'attributes' => $attr,
            ],
        ], 200);
    }
}
