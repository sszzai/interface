<?php
/**
 * @desc 日志
 * @date 2022/1/6 14:20
 * @copyright 小码科技
 */

namespace Sszzai\Lib;
use Sszzai\Config\Config;
use Sszzai\Factory;
use RuntimeException;

class FileLog
{
    private $log = '.';

    public function save($title, $data = [], $level_str = "info", $file = "common")
    {
         $this->file($title, $data, $level_str, $file);
    }

    private function file($code, $data = [], $level_str = "info", $file = "common")
    {
        $filename = $this->buildLogFile($file);
        $msg = $this->jsonFormat($code, $data, $level_str) . "\n";
        \Swoole\Coroutine\go(function () use($filename,$msg) {
            \file_put_contents($filename, $msg, FILE_APPEND);
        });
    }


    //日志格式
    //时间+标识+状态码+预警等级+具体内容
    private function jsonFormat($code, $data = [], $level_str = "info")
    {
        $time = date("Y-m-d H:i:s");
        return sprintf("%s|%s|%s|%d|%s", $time, "chat", $code, strtoupper($level_str), json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    private function buildLogFile($file = 'common')
    {
        $file_path = $this->log . "/" . date('Ymd') . "_" . $file . ".log";
        $dir = dirname($file_path);
        if (file_exists($dir)) {
            if (!is_writeable($dir) && !chmod($dir, 0777)) {
                throw new RuntimeException(__CLASS__ . ": {$dir} unwriteable.");
            }
        } elseif (mkdir($dir, 0777, true) === false) {
            throw new RuntimeException(__CLASS__ . ": mkdir dir {$dir} fail.");
        }
        return $file_path;
    }
}
