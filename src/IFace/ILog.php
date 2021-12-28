<?php

/**
 * @desc 日志接口
 * @date 2021/11/15 11:48
 * @copyright 小码科技
 */
namespace Sszzai\IFace;
interface ILog
{

    /**
     * 提示
     * @param $app 应用名称
     * @param $msg 日志标题
     * @param array $data 附加数据
     * @param false $alert 是否报警
     * @return mixed
     */
    public function info($app,$msg,$data=[],$alert=false);

    /**
     * 调试
     * @param $app 应用名称
     * @param $msg 日志标题
     * @param array $data 附加数据
     * @param false $alert 是否报警
     * @return mixed
     */
    public function debug($app,$msg,$data=[],$alert=false);

    /**
     * 警告
     * @param $app 应用名称
     * @param $msg 日志标题
     * @param array $data 附加数据
     * @param false $alert 是否报警
     * @return mixed
     */
    public function warn($app,$msg,$data=[],$alert=false);

    /**
     * 一般错误
     * @param $app 应用名称
     * @param $msg 日志标题
     * @param array $data 附加数据
     * @param false $alert 是否报警
     * @return mixed
     */
    public function error($app,$msg,$data=[],$alert=false);

    /**
     * 致命错误
     * @param $app 应用名称
     * @param $msg 日志标题
     * @param array $data 附加数据
     * @param false $alert 是否报警
     * @return mixed
     */
    public function fatal($app,$msg,$data=[],$alert=false);

    /**
     * 流程追踪
     * @param $type 类型
     * @param $step 步骤
     * @param $msg 日志标题
     * @param array $data 数据
     * @return mixed
     */
    public function trace($type,$step,$msg,$data=[],$alert=false);

}