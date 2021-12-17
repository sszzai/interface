<?php

/**
 * @desc 日志接口
 * @date 2021/11/15 11:48
 * @copyright 小码科技
 */
namespace Sszzai\IFace;
interface ILog
{

    public function info($application,$errorCode,$log);
    public function debug($application,$errorCode,$log);
    public function warn($application,$errorCode,$log);
    public function error($application,$errorCode,$log);
    public function fatal($application,$errorCode,$log);

    public function trace($type,$step,$log);

}