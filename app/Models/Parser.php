<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Parser extends Model
{
    use HasFactory;

    protected static $access_key = 'r_dZQDQ9FStM9lZ';
    protected static $puid = '441535';

    public static function getMainers($page = 1) {
        $page_size = 50;
        $url = 'https://pool.btc.com/v1/worker?access_key='.self::$access_key.'&puid='.self::$puid.'&group=0&status=all&page='.$page.'&page_size='.$page_size.'&asc=1&order_by=worker_name';
        $response = Http::withOptions(['proxy' => 'http://'.env('PROXY')])->get($url);

        return json_decode($response->body());
    }

    public static function getHistory($mainer_id, $start) {
        $url = 'https://pool.btc.com/v1/worker/'.$mainer_id.'/share-history?access_key='.self::$access_key.'&puid='.self::$puid.'&dimension=1h&start_ts='.$start.'&real_point=1&count=500';
        $response = Http::withOptions(['proxy' => 'http://'.env('PROXY')])->get($url);

        return json_decode($response->body());
    }


}
