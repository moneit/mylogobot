<?php

namespace App\Services;

use App\Helpers\OAuthConsumer;
use App\Helpers\OAuthRequest;
use App\Helpers\OAuthSignatureMethod_HMAC_SHA1;
use App\Helpers\OAuthUtil;

class TheNounProjectService
{
    public static function getData(String $keyword, $page = 1, $count = 100)
    {
        // todo: update using Guzzle, remove from autoload, autoload-dev in composer.json, remove anlute from composer.json require, remove App\Helpers\OAuth
        $cc_key  = "7a8a1caf65fa4d4ba7136aaa556fca71";
        $cc_secret = "d45ac367e13f4940bad88a0d9f5ceca5";

//        $search_input = $request->input('search_input', '');

//        $tags = preg_split("/[\s,]+/", $search_input);
        if (empty($keyword)) {
            $keyword = 'icons'; // default keyword
        }

        $tag = self::getTagFromKeyword($keyword);

        $results = [];

        $url = "http://api.thenounproject.com/icons/" . $tag;
        $args = [
            'limit' => $count,
            'page' => $page,
        ];

        $consumer = new OAuthConsumer($cc_key, $cc_secret);
        $query = OAuthRequest::from_consumer_and_token($consumer, NULL,"GET", $url, $args);
        $query->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $consumer, NULL);
        $url = sprintf("%s?%s", $url, OAuthUtil::build_http_query($args));
        $ch = curl_init();
        $headers = array($query->to_header());
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $rsp = curl_exec($ch);
        $info = curl_getinfo( $ch );
        $err = curl_error($ch);

        curl_close($ch);

        try {
            if (is_object(json_decode($rsp))) {
                $icons = json_decode($rsp)->icons;
            } else {
                $icons = [];
            }
        } catch(\Exception $e) {
            \Log::error('Failed to get icons for keyword '.$tag);
            $icons = [];
        }

        $data = [];

        foreach($icons as $icon) {
//                $imageData = base64_encode(file_get_contents($icon->icon_url));
//                $imageData = file_get_contents($icon->icon_url);

            $data[] = [
                'preview_url' => $icon->preview_url,
                'icon_url' => $icon->icon_url,
            ];
        }

        if($info['http_code'] === 200){
//                $response_body[] = ['info' => $info, 'body' => collect($icons)->pluck('preview_url'), 'error' => $err];
            $results = ['info' => $info, 'body' => $data, 'error' => $err];
        }

        return $results;
    }

    public static function getTagFromKeyword(String $keyword)
    {
        return implode('-', explode(' ', $keyword));
    }
}