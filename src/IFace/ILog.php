<?php

/**
 * @desc 日志接口
 * @date 2021/11/15 11:48
 * @copyright 小码科技
 */
namespace Sszzai\IFace;
interface ILog
{

    public function info($app,$msg,$data=[]);
    public function debug($app,$msg,$data=[]);
    public function warn($app,$msg,$data=[]);
    public function error($app,$msg,$data=[]);
    public function fatal($app,$msg,$data=[]);
    public function trace($type,$step,$msg,$data=[]);

}