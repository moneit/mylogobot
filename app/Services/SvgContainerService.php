<?php

namespace App\Services;

use App\Container;
use phpDocumentor\Reflection\Types\Integer;

class SvgContainerService
{// todo: create mixin SvgParser to be used in both svg font service and container service
    /**
     * @var \SimpleXMLElement
     */
    private $svg;

    /**
     * @var integer
     *
     * min x of view box
     */
    private $minX;

    /**
     * @var integer
     *
     * min y of view box
     */
    private $minY;

    /**
     * @var integer
     *
     * max x of view box
     */
    private $maxX;

    /**
     * @var integer
     *
     * max y of view box
     */
    private $maxY;

    /**
     * @var string
     */
    private $shapes;

    public function __construct($containerId)
    {
        $this->svg = simplexml_load_file($this->__getFilePathFromId($containerId));
        $this->readViewBox(); // todo: move to DB, containers table, column name should be like x_view_min, x_view_max, y_view_min, y_view_max
        $this->readShapeString();
    }

    private function __getFilePathFromId($id)
    {
        $container = Container::findOrFail($id);
        return "./storage/containers/{$container->file_name}";
    }

    private function readShapeString()
    {
        $res = $this->traverse($this->svg, function(\SimpleXMLElement $tag) {
            if ($tag->getName() === 'g') {
                foreach($tag as $child) {
                    if ($child->getName() === 'g') {
                        return NULL;
                    }
                }
                $data = array();
                foreach($tag as $child) {
                    $datum = array();
                    $datum['tag'] = $child->getName();
                    foreach($child->attributes() as $attr => $value) {
                        $datum[$attr] = (string)$value;
                    }
                    array_push($data, $datum);
                }
                return $data;
            }
            return NULL;
        });

        if (count($res) === 1) {
            $this->shapes = $res[0];
        } else {
            $this->shapes = NULL;
        }
    }

    public function getShapes()
    {
        return $this->shapes;
    }

    private function readViewBox()
    {
        $this->traverse($this->svg, function(\SimpleXMLElement $tag) {
            if ($tag->getName() === 'svg') {
                $boundingBox = explode(' ', $tag['viewBox']);
                $this->minX = (integer)$boundingBox[0];
                $this->minY = (integer)$boundingBox[1];
                $this->maxX = (integer)$boundingBox[2];
                $this->maxY = (integer)$boundingBox[3];
            }
            return NULL;
        });
    }

    public function getViewBox()
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
}