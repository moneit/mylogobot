<?php

namespace App\Services;

use App\Font;
use phpDocumentor\Reflection\Types\Integer;

class SvgIconService
{
    /**
     * @var \SimpleXMLElement
     */
    private $svg;

    /**
     * @var integer
     *
     * global horiz-adv-x
     */
    private $horizAdvX;

    /**
     * @var integer
     *
     * min x of bounding box
     */
    private $minX;

    /**
     * @var integer
     *
     * min y of bounding box
     */
    private $minY;

    /**
     * @var integer
     *
     * max x of bounding box
     */
    private $maxX;

    /**
     * @var integer
     *
     * max y of bounding box
     */
    private $maxY;

    public function __construct($svg)
    {
        $this->svg = simplexml_load_string($svg);
        $this->readBoundingBox();
    }

    private function readBoundingBox()
    {
//        $this->traverse($this->svg, function(\SimpleXMLElement $tag) {
//            if ($tag->getName() === 'svg') {
            if ($this->svg->getName() === 'svg') {
//                $boundingBox = explode(' ', $tag['viewBox']);
                $boundingBox = explode(' ', $this->svg['viewBox']);
                $this->minX = (float)$boundingBox[0];
                $this->minY = (float)$boundingBox[1];
                $this->maxX = $this->minX + (float)$boundingBox[2];
                $this->maxY = $this->minY + (float)$boundingBox[3];
            }
//            return NULL;
//        });
    }

    public function getBounds()
    {
        return [
            'minX' => $this->minX,
            'minY' => $this->minY,
            'maxX' => $this->maxX,
            'maxY' => $this->maxY,
        ];
    }

    private function traverse(\SimpleXMLElement $tag, \Closure $f) // todo: update using xpath: http://php.net/manual/en/simplexmlelement.xpath.php
    {
        $result = [];
        foreach($tag as $child) {
            $result = array_merge($result, $this->traverse($child, $f));
        }

        $data = $f($tag);
        if (!is_null($data)) {
            $result[] = $data;
        }

        return $result;
    }

    public function asXml()
    {
        $xmls = [];
        foreach($this->svg->children() as $child) {
            $xmls[] = $child->asXML();
        }

        return $xmls;
    }

    public function getAttributes()
    {
        return $this->svg->attributes();
    }
}