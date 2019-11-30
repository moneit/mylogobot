<?php

namespace App\Services;


class FreeJpgService
{
    private $freeJpgLinkBasePath;
    private $freeJpgBasePath;

    public function __construct()
    {
        $this->freeJpgLinkBasePath = '/img/free';
        $this->freeJpgBasePath = getcwd() . $this->freeJpgLinkBasePath;
    }

    public function generateFreeJpgFile($logo)
    {
        $uniqueId = uniqid();
        $basePath = $this->freeJpgBasePath;

        $svgTempFilePath = $basePath . '/' . $uniqueId . '.svg';
        $pngTempFilePath = $basePath . '/' . $uniqueId . '.png';
        file_put_contents($svgTempFilePath, $logo->svg);

        $command = 'inkscape --file="' . $svgTempFilePath . '" --export-png="' . $pngTempFilePath . '" --export-background=' . $logo->bg_color . ' --export-dpi=48' . ' --without-gui';
        exec($command);

        $targetFilePath = $basePath . '/' . $uniqueId . '.jpg';
        $command = 'convert "' . $pngTempFilePath . '" -background white -flatten "' . $targetFilePath . '"';
        exec($command);

        \File::delete($svgTempFilePath);
        \File::delete($pngTempFilePath);

        return $uniqueId;
    }

    public static function generateFreeJpgDownloadLink(String $fileId)
    {
        return route('free-download', [
            'fileName' => $fileId . '.jpg',
        ]);
    }

    public function getFreeJpgLink($fileId)
    {
        return $this->freeJpgLinkBasePath . '/' . $fileId . '.jpg';
    }

    public function getFreeJpgPath($fileName)
    {
        return $this->freeJpgBasePath . '/' . $fileName;
    }
}