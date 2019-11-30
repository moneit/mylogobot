<?php

namespace App\Services;

use App\Font;
use phpDocumentor\Reflection\Types\Integer;

class SvgFontService
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

    public function __construct($fontId)
    {
        $this->svg = simplexml_load_file($this->__getFilePathFromId($fontId));
        $this->readGlobalHorizAdvX(); // todo: move to DB, fonts table, column name should be like global_horiz_adv_x
        $this->readBoundingBox(); // todo: move to DB, fonts table, column name should be like x_bound_min, x_bound_max, y_bound_min, y_bound_max
    }

    private function __getFilePathFromId($id)
    {
        $font = Font::findOrFail($id);
        return "./storage/Font/{$font->category}/{$font->family}/{$font->filename}";
    }

    public function getPathsByString(String $string)
    {
        $chars = splitByUnicode($string);
        $paths = [];
        foreach ($chars as $char) {
            $path = $this->getPathByUnicode($char);
            if (is_null($path)) {
                $path = $this->getPathByGlyph($char);
            }
            if (is_null($path)) {
                throw new \Exception("Could not get path from character - $char");
            }
            $paths[] = $path;
        }
        return $paths;
    }

    private function getPathByGlyph($char)
    {
        $res = $this->traverse($this->svg, function(\SimpleXMLElement $tag) use ($char) {
            if ($tag->getName() === 'glyph') {
                if ((string)$tag['glyph-name'] === $char) {
                    return [
                        'path' => (string)$tag['d'],
                        'horiz-adv-x' => (integer)$tag['horiz-adv-x'] > 0 ? (integer)$tag['horiz-adv-x'] : $this->horizAdvX, // return global horiz-adv-x when it is not specified in glyph, https://www.w3.org/TR/SVG11/fonts.html#GlyphElementHorizAdvXAttribute
                        'char' => $char,
                    ];
                }
            }
            return NULL;
        });

        if (count($res) === 1) {
            return $res[0];
        } else {
            return NULL;
        }
    }

    private function getPathByUnicode($unicode)
    {
        $res = $this->traverse($this->svg, function(\SimpleXMLElement $tag) use ($unicode) {
            if ($tag->getName() === 'glyph') {
                if ((string)$tag['unicode'] === $unicode || (string)$tag['unicode'] === unicodeToNumericEntity($unicode) ) {
                    return [
                        'path' => (string)$tag['d'],
                        'horiz-adv-x' => (integer)$tag['horiz-adv-x'] > 0 ? (integer)$tag['horiz-adv-x'] : $this->horizAdvX, // return global horiz-adv-x when it is not specified in glyph, https://www.w3.org/TR/SVG11/fonts.html#GlyphElementHorizAdvXAttribute
                        'char' => $unicode,
                    ];
                }
            }
            return NULL;
        });

        if (count($res) === 1) {
            return $res[0];
        } else {
            return NULL;
        }
    }

    private function readGlobalHorizAdvX()
    {
        $this->traverse($this->svg, function(\SimpleXMLElement $tag) {
            if ($tag->getName() === 'font') {
                $this->horizAdvX = (integer)$tag['horiz-adv-x'];
            }
            return NULL;
        });
    }

    public function getGlobalHorizAdvX()
    {
        if ($this->horizAdvX === 0) {
            $spaceData = $this->getPathByUnicode(' ');
            if (is_null($spaceData)) {
                return NULL;
            }
            return $spaceData['horiz-adv-x'];
        }
        return $this->horizAdvX;
    }

    private function readBoundingBox()
    {
        $this->traverse($this->svg, function(\SimpleXMLElement $tag) {
            if ($tag->getName() === 'font-face') {
                if ($tag['bbox']) {
                    $boundingBox = explode(' ', $tag['bbox']);
                    $this->minX = (integer)$boundingBox[0];
                    $this->minY = (integer)$boundingBox[1];
                    $this->maxX = (integer)$boundingBox[2];
                    $this->maxY = (integer)$boundingBox[3];
                } else if ($tag['ascent'] && $tag['descent']) {
                    $this->minX = 0;
                    $this->minY = (integer)$tag['descent'];
                    $this->maxX = $this->getGlobalHorizAdvX();
                    $this->maxY = (integer)$tag['ascent'];
                }
            }
            return NULL;
        });
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

    private static function _uniord($c) {
        if (ord($c{0}) >=0 && ord($c{0}) <= 127)
            return ord($c{0});
        if (ord($c{0}) >= 192 && ord($c{0}) <= 223)
            return (ord($c{0})-192)*64 + (ord($c{1})-128);
        if (ord($c{0}) >= 224 && ord($c{0}) <= 239)
            return (ord($c{0})-224)*4096 + (ord($c{1})-128)*64 + (ord($c{2})-128);
        if (ord($c{0}) >= 240 && ord($c{0}) <= 247)
            return (ord($c{0})-240)*262144 + (ord($c{1})-128)*4096 + (ord($c{2})-128)*64 + (ord($c{3})-128);
        if (ord($c{0}) >= 248 && ord($c{0}) <= 251)
            return (ord($c{0})-248)*16777216 + (ord($c{1})-128)*262144 + (ord($c{2})-128)*4096 + (ord($c{3})-128)*64 + (ord($c{4})-128);
        if (ord($c{0}) >= 252 && ord($c{0}) <= 253)
            return (ord($c{0})-252)*1073741824 + (ord($c{1})-128)*16777216 + (ord($c{2})-128)*262144 + (ord($c{3})-128)*4096 + (ord($c{4})-128)*64 + (ord($c{5})-128);
        if (ord($c{0}) >= 254 && ord($c{0}) <= 255)    //  error
            return FALSE;
        return 0;
    }   //  function _uniord()
}