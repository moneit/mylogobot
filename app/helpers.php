<?php

if (! function_exists('splitByUnicode')) {
    /**
     * @param $str
     * @param int $length
     *
     * @return array|array[]|false|string[]
     */
    function splitByUnicode($str, $length = 1)
    {
        $tmp = preg_split('~~u', $str, -1, PREG_SPLIT_NO_EMPTY);
        if ($length > 1) {
            $chunks = array_chunk($tmp, $length);
            foreach ($chunks as $i => $chunk) {
                $chunks[$i] = join('', (array) $chunk);
            }
            $tmp = $chunks;
        }
        return $tmp;
    }
}

function unicodeToNumericEntity($str)
{
    return preg_replace_callback("/(&#[0-9]+;)/", function($m) { return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES"); }, $str);
}