<?php

namespace App\Services;

use App\Logo;
use App\Package;

class ProductService
{
    const plans = [
        Package::basicPackageName => [
            [ 'extension' => 'png', 'background' => true, 'dpi' => 48, ],
            [ 'extension' => 'jpg', 'background' => true, 'dpi' => 48, ],
        ],
        Package::premiumPackageName => [
            [ 'extension' => 'png', 'dpi' => 300, 'dir' => 'png', 'tag' => 'color logo transparent', 'background' => false, ],
            [ 'extension' => 'png', 'dpi' => 300, 'dir' => 'png', 'tag' => 'white logo transparent', 'color' => 'white', 'background' => false, ],
            [ 'extension' => 'png', 'dpi' => 300, 'dir' => 'png', 'tag' => 'dark logo transparent', 'color' => 'black', 'background' => false, ],
            [ 'extension' => 'png', 'dpi' => 300, 'dir' => 'png', 'tag' => 'color logo with background', 'background' => true, ],

            [ 'extension' => 'eps', 'dpi' => 300, 'dir' => 'eps', 'tag' => 'color logo transparent', 'background' => false, ],
            [ 'extension' => 'eps', 'dpi' => 300, 'dir' => 'eps', 'tag' => 'white logo transparent', 'color' => 'white', 'background' => false, ],
            [ 'extension' => 'eps', 'dpi' => 300, 'dir' => 'eps', 'tag' => 'dark logo transparent', 'color' => 'black', 'background' => false, ],
            [ 'extension' => 'eps', 'dpi' => 300, 'dir' => 'eps', 'tag' => 'color logo with background', 'background' => true, ],

            [ 'extension' => 'svg', 'dpi' => 300, 'dir' => 'svg', 'tag' => 'color logo transparent', 'background' => false, ],
            [ 'extension' => 'svg', 'dpi' => 300, 'dir' => 'svg', 'tag' => 'white logo transparent', 'color' => 'white', 'background' => false, ],
            [ 'extension' => 'svg', 'dpi' => 300, 'dir' => 'svg', 'tag' => 'dark logo transparent', 'color' => 'black', 'background' => false, ],
            [ 'extension' => 'svg', 'dpi' => 300, 'dir' => 'svg', 'tag' => 'color logo with background', 'background' => true, ],

            [ 'extension' => 'pdf', 'dpi' => 300, 'dir' => 'pdf', 'tag' => 'color logo transparent', 'background' => false, ],
            [ 'extension' => 'pdf', 'dpi' => 300, 'dir' => 'pdf', 'tag' => 'white logo transparent', 'color' => 'white', 'background' => false, ],
            [ 'extension' => 'pdf', 'dpi' => 300, 'dir' => 'pdf', 'tag' => 'dark logo transparent', 'color' => 'black', 'background' => false, ],
            [ 'extension' => 'pdf', 'dpi' => 300, 'dir' => 'pdf', 'tag' => 'color logo with background', 'background' => true, ],
        ],
        Package::enterprisePackageName => [
            [ 'extension' => 'png', 'width' => 1584, 'height' => 396, 'area' => '-1024:0:2048:768', 'dir' => 'Social Media Assets/Linkedin', 'tag' => 'background image', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 1584, 'height' => 396, 'area' => '-1024:0:2048:768', 'dir' => 'Social Media Assets/Linkedin', 'tag' => 'background image without slogan', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 1584, 'height' => 396, 'area' => '-1024:0:2048:768', 'dir' => 'Social Media Assets/Linkedin', 'tag' => 'background image symbol', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 1000, 'height' => 1000, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Linkedin', 'tag' => 'profile image', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 1000, 'height' => 1000, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Linkedin', 'tag' => 'profile image without slogan', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 1000, 'height' => 1000, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Linkedin', 'tag' => 'profile image symbol', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 600, 'height' => 600, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Linkedin', 'tag' => 'company logo', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 600, 'height' => 600, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Linkedin', 'tag' => 'company logo without slogan', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 600, 'height' => 600, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Linkedin', 'tag' => 'company logo symbol', 'background' => true, ],

            [ 'extension' => 'png', 'width' => 200, 'height' => 200, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Email', 'tag' => 'Email symbol', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 200, 'height' => 200, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Email', 'tag' => 'Email without slogan', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 200, 'height' => 200, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Email', 'tag' => 'Email', 'background' => true, ],

            [ 'extension' => 'png', 'width' => 1000, 'height' => 1000, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Instagram', 'tag' => 'profile picture without slogan', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 1000, 'height' => 1000, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Instagram', 'tag' => 'profile picture', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 1000, 'height' => 1000, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Instagram', 'tag' => 'profile picture symbol', 'background' => true, ],

            [ 'extension' => 'png', 'width' => 768, 'height' => 1024, 'area' => '0:-298:1024:1067', 'dir' => 'Social Media Assets/Ipad', 'tag' => 'Ipad Mini', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 768, 'height' => 1024, 'area' => '0:-298:1024:1067', 'dir' => 'Social Media Assets/Ipad', 'tag' => 'Ipad Mini without slogan', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 768, 'height' => 1024, 'area' => '0:-298:1024:1067', 'dir' => 'Social Media Assets/Ipad', 'tag' => 'Ipad Mini symbol', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 1536, 'height' => 2048, 'area' => '0:-298:1024:1067', 'dir' => 'Social Media Assets/Ipad', 'tag' => 'Ipad Retina', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 1536, 'height' => 2048, 'area' => '0:-298:1024:1067', 'dir' => 'Social Media Assets/Ipad', 'tag' => 'Ipad Retina without slogan', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 1536, 'height' => 2048, 'area' => '0:-298:1024:1067', 'dir' => 'Social Media Assets/Ipad', 'tag' => 'Ipad Retina symbol', 'background' => true, ],

            [ 'extension' => 'png', 'width' => 640, 'height' => 960, 'area' => '0:-256:1024:1280', 'dir' => 'Social Media Assets/Iphone', 'tag' => 'Iphone 4', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 640, 'height' => 960, 'area' => '0:-256:1024:1280', 'dir' => 'Social Media Assets/Iphone', 'tag' => 'Iphone 4 without slogan', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 640, 'height' => 960, 'area' => '0:-256:1024:1280', 'dir' => 'Social Media Assets/Iphone', 'tag' => 'Iphone 4 symbol', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 640, 'height' => 1136, 'area' => '0:-525:1024:1293', 'dir' => 'Social Media Assets/Iphone', 'tag' => 'Iphone 5', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 640, 'height' => 1136, 'area' => '0:-525:1024:1293', 'dir' => 'Social Media Assets/Iphone', 'tag' => 'Iphone 5 without slogan', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 640, 'height' => 1136, 'area' => '0:-525:1024:1293', 'dir' => 'Social Media Assets/Iphone', 'tag' => 'Iphone 5 symbol', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 750, 'height' => 1334, 'area' => '0:-526:1024:1294', 'dir' => 'Social Media Assets/Iphone', 'tag' => 'Iphone 6', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 750, 'height' => 1334, 'area' => '0:-526:1024:1294', 'dir' => 'Social Media Assets/Iphone', 'tag' => 'Iphone 6 without slogan', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 750, 'height' => 1334, 'area' => '0:-526:1024:1294', 'dir' => 'Social Media Assets/Iphone', 'tag' => 'Iphone 6 symbol', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 1242, 'height' => 2208, 'area' => '0:-526:1024:1294', 'dir' => 'Social Media Assets/Iphone', 'tag' => 'Iphone 6 Plus', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 1242, 'height' => 2208, 'area' => '0:-526:1024:1294', 'dir' => 'Social Media Assets/Iphone', 'tag' => 'Iphone 6 Plus without slogan', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 1242, 'height' => 2208, 'area' => '0:-526:1024:1294', 'dir' => 'Social Media Assets/Iphone', 'tag' => 'Iphone 6 Plus symbol', 'background' => true, ],

            [ 'extension' => 'png', 'width' => 1920, 'height' => 1080, 'area' => '-171:0:1195:768', 'dir' => 'Social Media Assets/Wallpaper', 'tag' => 'wallpaper', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 1920, 'height' => 1080, 'area' => '-171:0:1195:768', 'dir' => 'Social Media Assets/Wallpaper', 'tag' => 'wallpaper without slogan', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 1920, 'height' => 1080, 'area' => '-171:0:1195:768', 'dir' => 'Social Media Assets/Wallpaper', 'tag' => 'wallpaper symbol', 'background' => true, ],

            [ 'extension' => 'png', 'width' => 1200, 'height' => 1200, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Facebook', 'tag' => 'profile', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 1200, 'height' => 1200, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Facebook', 'tag' => 'profile picture without slogan', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 1200, 'height' => 1200, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Facebook', 'tag' => 'profile picture symbol', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 2460, 'height' => 936, 'area' => '-497:0:1521:768', 'dir' => 'Social Media Assets/Facebook', 'tag' => 'cover photo', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 2460, 'height' => 936, 'area' => '-497:0:1521:768', 'dir' => 'Social Media Assets/Facebook', 'tag' => 'cover photo without slogan', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 2460, 'height' => 936, 'area' => '-497:0:1521:768', 'dir' => 'Social Media Assets/Facebook', 'tag' => 'cover photo symbol', 'background' => true, ],

            [ 'extension' => 'png', 'width' => 600, 'height' => 600, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Watermark', 'tag' => 'watermark', 'background' => false, ],
            [ 'extension' => 'png', 'width' => 400, 'height' => 400, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Watermark', 'tag' => 'watermark@2x', 'background' => false, ],

            [ 'extension' => 'png', 'width' => 800, 'height' => 800, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Youtube', 'tag' => 'profile image', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 800, 'height' => 800, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Youtube', 'tag' => 'profile image without slogan', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 800, 'height' => 800, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Youtube', 'tag' => 'profile image symbol', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 2560, 'height' => 1440, 'area' => '-171:0:1195:768', 'dir' => 'Social Media Assets/Youtube', 'tag' => 'cover photo', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 2560, 'height' => 1440, 'area' => '-171:0:1195:768', 'dir' => 'Social Media Assets/Youtube', 'tag' => 'cover photo without slogan', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 2560, 'height' => 1440, 'area' => '-171:0:1195:768', 'dir' => 'Social Media Assets/Youtube', 'tag' => 'cover photo symbol', 'background' => true, ],

            [ 'extension' => 'png', 'width' => 170, 'height' => 100, 'area' => '-141:0:1165:768', 'dir' => 'Social Media Assets/Etsy', 'tag' => 'team logo', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 170, 'height' => 100, 'area' => '-141:0:1165:768', 'dir' => 'Social Media Assets/Etsy', 'tag' => 'team logo without slogan', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 170, 'height' => 100, 'area' => '-141:0:1165:768', 'dir' => 'Social Media Assets/Etsy', 'tag' => 'team logo symbol', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 400, 'height' => 400, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Etsy', 'tag' => 'profile image', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 400, 'height' => 400, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Etsy', 'tag' => 'profile image without slogan', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 400, 'height' => 400, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Etsy', 'tag' => 'profile image symbol', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 3360, 'height' => 840, 'area' => '-1024:0:2048:768', 'dir' => 'Social Media Assets/Etsy', 'tag' => 'cover photo', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 3360, 'height' => 840, 'area' => '-1024:0:2048:768', 'dir' => 'Social Media Assets/Etsy', 'tag' => 'cover photo without slogan', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 3360, 'height' => 840, 'area' => '-1024:0:2048:768', 'dir' => 'Social Media Assets/Etsy', 'tag' => 'cover photo symbol', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 1520, 'height' => 200, 'area' => '-2406:0:3430:768', 'dir' => 'Social Media Assets/Etsy', 'tag' => 'shop banner', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 1520, 'height' => 200, 'area' => '-2406:0:3430:768', 'dir' => 'Social Media Assets/Etsy', 'tag' => 'shop banner without slogan', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 1520, 'height' => 200, 'area' => '-2406:0:3430:768', 'dir' => 'Social Media Assets/Etsy', 'tag' => 'shop banner symbol', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 500, 'height' => 500, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Etsy', 'tag' => 'shop icon', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 500, 'height' => 500, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Etsy', 'tag' => 'shop icon without slogan', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 500, 'height' => 500, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Etsy', 'tag' => 'shop icon symbol', 'background' => true, ],

            [ 'extension' => 'png', 'width' => 32, 'height' => 32, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Favicon', 'tag' => 'favicon', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 32, 'height' => 32, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Favicon', 'tag' => 'favicon without slogan', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 32, 'height' => 32, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Favicon', 'tag' => 'favicon symbol', 'background' => true, ],

            [ 'extension' => 'png', 'width' => 600, 'height' => 600, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Quickbooks', 'tag' => 'icon', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 600, 'height' => 600, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Quickbooks', 'tag' => 'icon without slogan', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 600, 'height' => 600, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Quickbooks', 'tag' => 'icon symbol', 'background' => true, ],

            [ 'extension' => 'png', 'width' => 330, 'height' => 330, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Quickbooks', 'tag' => 'profile picture', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 330, 'height' => 330, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Quickbooks', 'tag' => 'profile picture without slogan', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 330, 'height' => 330, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Quickbooks', 'tag' => 'profile picture symbol', 'background' => true, ],

            [ 'extension' => 'png', 'width' => 800, 'height' => 800, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Twitter', 'tag' => 'profile picture', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 800, 'height' => 800, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Twitter', 'tag' => 'profile picture without symbol', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 800, 'height' => 800, 'area' => '0:-128:1024:896', 'dir' => 'Social Media Assets/Twitter', 'tag' => 'profile picture slogan', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 1500, 'height' => 500, 'area' => '-640:0:1664:768', 'dir' => 'Social Media Assets/Twitter', 'tag' => 'header photo', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 1500, 'height' => 500, 'area' => '-640:0:1664:768', 'dir' => 'Social Media Assets/Twitter', 'tag' => 'header photo without slogan', 'background' => true, ],
            [ 'extension' => 'png', 'width' => 1500, 'height' => 500, 'area' => '-640:0:1664:768', 'dir' => 'Social Media Assets/Twitter', 'tag' => 'header photo symbol', 'background' => true, ],
        ],
    ];

    private $basePath;

    public function __construct()
    {
        $this->basePath = getcwd() . '/storage/temp';
    }

    /**
     * @param string $productName
     * @param Logo $logo
     *
     * @return string path to zip file
     */
    public function generate(string $productName, Logo $logo)
    {
        // generate temporary svg file

        $dirName = $this->getDirName($logo->id);

        if (file_exists($this->basePath . '/' . $dirName)) {
            \Log::error('The logo is being generated now or was not fully finished in last generation.');

            return null;
        }

        \File::makeDirectory($this->basePath . '/' . $dirName, octdec('0777'), true, true);
//        \File::makeDirectory($this->basePath . '/' . $dirName); // todo: test permission and remove 777 if possible - compare above line

        $productDirPath = $this->basePath . '/' . $dirName . '/product';
        \File::makeDirectory($productDirPath, octdec('0777'), true, true);
//        \File::makeDirectory($productDirPath); // todo: test permission and remove 777 if possible - compare above line

        $uniqueId = uniqid();

        switch ($productName) {
            case Package::enterprisePackageName:
                self::generateFilesForProduct(Package::enterprisePackageName, $uniqueId, $this->basePath, $dirName, $productDirPath, $logo);
            case Package::premiumPackageName:
                self::generateFilesForProduct(Package::premiumPackageName, $uniqueId, $this->basePath, $dirName, $productDirPath, $logo);
            case Package::basicPackageName: // basic package is not supported anymore, instead jpg file is generated
//                self::generateFilesForProduct(Package::basicPackageName, $uniqueId, $this->basePath, $dirName, $productDirPath, $logo);
        }

        $zipFileName = $uniqueId . '.zip';
        $zipFilePath = $this->basePath . '/' . $dirName . '/' . $zipFileName;
        $command = 'pushd ' . $productDirPath . ' && zip --recurse-paths ' . $zipFilePath . ' . && popd';
        exec($command, $output);

        \File::move($zipFilePath, $this->basePath . '/' . $zipFileName);
        \File::deleteDirectory($this->basePath . '/' . $dirName);

        return $uniqueId;
    }

    /**
     * @param int $logoId
     * @param String $fileId
     * @return string
     */
    public static function generateDownloadLink(int $logoId, String $fileId)
    {
        return route('download', [
            'logoId' => $logoId,
            'fileName' => $fileId . '.zip',
        ]);
    }

    private static function generateFilesForProduct($productName, $uniqueId, $basePath, $dirName, $productDirPath, $logo)
    {
        foreach(self::plans[$productName] as $option) {

            if (isset($option['tag']) && strpos($option['tag'], 'symbol') !== false ) {
                $svg = $logo->symbol_only_svg;
            } else {
                $svg = $logo->svg;
            }

            $svg = preg_replace('/<pattern id="watermark-pattern".*?><\/pattern>/i', '', $svg, 1); // remove watermark pattern from svg
            $svg = preg_replace('/<rect id="watermark".*?><\/rect>/i', '', $svg, 1); // remove watermark from svg

            if (isset($option['background']) && $option['background']) {
                // do nothing
            } else {
                $svg = preg_replace('/<rect id="background".*?><\/rect>/i', '', $svg, 1); // remove background from svg
            }

            if (isset($option['tag']) && strpos($option['tag'], 'without slogan') !== false ) {
                $svg = preg_replace('/<g id="logo-slogan".*?><\/g>/i', '', $svg, 1); // remove slogan from svg
            }

            if (isset($option['color']) && $option['color'] === 'white') {
                $svgTempFileName = $uniqueId . '.svg';
                $svgTempFilePath = $basePath . '/' . $dirName . '/' . $svgTempFileName;

                $whiteSvg = preg_replace('/fill="#[0-9|a-f]{3}"/i', 'fill="#ffffff"', $svg);
                $whiteSvg = preg_replace('/fill="#[0-9|a-f]{6}"/i', 'fill="#ffffff"', $whiteSvg);

                $whiteSvg = preg_replace('/stroke="#[0-9|a-f]{3}"/i', 'stroke="#ffffff"', $whiteSvg);
                $whiteSvg = preg_replace('/stroke="#[0-9|a-f]{6}"/i', 'stroke="#ffffff"', $whiteSvg);
                file_put_contents($svgTempFilePath, $whiteSvg);
            } else if (isset($option['color']) && $option['color'] === 'black') {
                $svgTempFileName = $uniqueId . '.svg';
                $svgTempFilePath = $basePath . '/' . $dirName . '/' . $svgTempFileName;

                $blackSvg = preg_replace('/fill="#[0-9|a-f]{3}"/i', 'fill="#000000"', $svg);
                $blackSvg = preg_replace('/fill="#[0-9|a-f]{6}"/i', 'fill="#000000"', $blackSvg);

                $blackSvg = preg_replace('/stroke="#[0-9|a-f]{3}"/i', 'stroke="#000000"', $blackSvg);
                $blackSvg = preg_replace('/stroke="#[0-9|a-f]{6}"/i', 'stroke="#000000"', $blackSvg);
                file_put_contents($svgTempFilePath, $blackSvg);
            } else {
                $svgTempFileName = $uniqueId . '.svg';
                $svgTempFilePath = $basePath . '/' . $dirName . '/' . $svgTempFileName;
                file_put_contents($svgTempFilePath, $svg);
            }

            self::generateSingleFile($option, $uniqueId, $svgTempFilePath, $productDirPath, $logo->bg_color);
        }
    }

    private static function generateSingleFile($option, $uniqueId, $svgTempFilePath, $productDirPath, $bgColor)
    {
        $targetFileName = $uniqueId;
        if (! empty($option['tag'])) {
            $targetFileName = implode('_', explode(' ', $option['tag']));
        }
        $targetFilePath = $productDirPath . '/' . $targetFileName . '.' . $option['extension'];
        if (! empty($option['dir'])) {
            $targetFilePath = $productDirPath . '/' . $option['dir'] . '/' . $targetFileName . '.' . $option['extension'];
            if (! file_exists($productDirPath . '/' . $option['dir'])) {
                \File::makeDirectory($productDirPath . '/' . $option['dir'], octdec('0777'), true, true);
//                \File::makeDirectory($productDirPath . '/' . $option['dir']);  // todo: test permission and remove 777 if possible - compare above line
            }
        }

        if ('jpg' === $option['extension']) {
            $tempPngFilePath = $productDirPath . '/' . $targetFileName . '_temp.png';
            if (! file_exists($tempPngFilePath)) {
                $option['extension'] = 'png';
                self::generateSingleFile($option, $uniqueId . '_temp', $svgTempFilePath, $productDirPath, $bgColor);
                $option['extension'] = 'jpg';
                $command = 'convert "' . $tempPngFilePath . '" -background white -flatten "' . $targetFilePath . '"';
                exec($command);
                \File::delete($tempPngFilePath);
            }
        } else {
            // sample 'inkscape --file path/to/svgFile.svg --export-png path/to/product.png --export-background #FFF'
            switch($option['extension']) {
                case 'svg':
                    $command = 'inkscape --file="' . $svgTempFilePath . '" --export-plain-svg="' . $targetFilePath . '"';
                    break;
                case 'png':
                case 'eps':
                case 'pdf':
                    $command = 'inkscape --file="' . $svgTempFilePath . '" --export-' . $option['extension'] . '="' . $targetFilePath . '"';
                    break;
                default:
                    return '';
            }

            if (isset($option['background']) && $option['background']) { // for png specially
                $command .= ' --export-background=' . $bgColor;
            }

            if (! empty($option['dpi'])) {
                $command .= ' --export-dpi=' . $option['dpi'];
            }

            if (! empty($option['width'])) {
                $command .= ' --export-width=' . $option['width'];
            }

            if (! empty($option['height'])) {
                $command .= ' --export-height=' . $option['height'];
            }

            if (! empty($option['area'])) {
                $command .= ' --export-area=' . $option['area'];
            }

            $command .= ' --without-gui';
            exec($command);
        }

        return $targetFilePath;
    }

    public function getProductPath($logoId, $fileName)
    {
        return $this->basePath . '/' . $fileName;
    }

    private function getDirName($logoId)
    {
        return 'logo_' . $logoId;
    }
}