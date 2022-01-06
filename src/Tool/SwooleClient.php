<?php
/**
 * @desc 基于swoole的协程 http 客户端
 * @date 2021/12/30 10:15
 * @copyright 小码科技
 */

namespace Sszzai\Tool;
use Sszzai\Factory;
use Sszzai\Lib\FileLog;
use Swlib\Saber;
class SwooleClient
{

    public static function post($url,$api,array $data,$headers = [], $timeout = 20) {
        \Swoole\Coroutine\go(function () use($url,$api,$headers,$data) {
            $saber = Saber::create([
                'base_uri' => $url,
                'headers' => $headers
            ]);
            $res = $saber->post($api, $data);
            $content = $res->getParsedJsonArray();

            Factory::make(FileLog::class)->save("SwooleClient post请求信息",[
                'host'=>$url,
                'api'=>$api,
                'data'=>$data,
                'headers'=>$headers,
                'result'=>$content
            ]);

            return $content;
        });
    }
}