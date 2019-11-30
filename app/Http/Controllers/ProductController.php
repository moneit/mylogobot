<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Logo;
use App\Order;
use App\Package as Product;
use App\Services\ProductService;
use App\Services\FreeJpgService;

class ProductController extends Controller
{
    /**
     * @var ProductService
     */
    private $productService;

    /**
     * @var FreeJpgService
     */
    private $freeJpgService;

    /**
     * LogoController constructor.
     * @param ProductService $productService
     * @param FreeJpgService $freeJpgService
     */
    public function __construct(ProductService $productService, FreeJpgService $freeJpgService)
    {
        $this->productService = $productService;
        $this->freeJpgService = $freeJpgService;
    }

    public function download($logoId, $fileName)
    {
        $pathToFile = $this->productService->getProductPath($logoId, $fileName);

        return response()->download($pathToFile);
    }

    public function downloadFreeJpg($fileName)
    {
        $pathToFile = $this->freeJpgService->getFreeJpgPath($fileName);

        return response()->download($pathToFile);
    }
}
