<?php

namespace App\Handlers;

use GuzzleHttp\Client;
use Overtrue\Pinyin\Pinyin;

class TranslateHandler
{

    protected $appid;
    protected $key;

    public function __construct()
    {
        $this->appid = config('services.baidu_translate.appid');
        $this->key = config('services.baidu_translate.key');
    }

    public function translate($text)
    {
        $http = new Client;

        $api = 'http://api.fanyi.baidu.com/api/trans/vip/granslate?';

        if (empty($this->appid) || empty($this->key)) {
            return $this->pinyin($text);
        }

        $salt = time();
        $sign = md5($this->appid . $text . $salt . $this->key);

        $query = http_build_query([
            "q" => $text,
            "from" => "zh",
            "to" => "en",
            "appid" => $this->appid,
            "salt" => $salt,
            "sign" => $sign,
        ]);

        $response = $http->get($api . $query);


        $result = json_decode($response->getBody(), true);
        // echo '<pre>';
        // var_dump($result);
        // var_dump($response);
        // exit;

        if (isset($result['trans_result'][0]['dst'])) {
            return \Str::slug($result['trans_result'][0]['dst']);
        } else {
            return $this->pinyin($text);
        }

    }

    public function pinyin($text)
    {
        return \Str::slug(app(Pinyin::class)->permalink($text));
    }
}
