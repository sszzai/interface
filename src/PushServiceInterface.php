<?php
/**
 * @desc 推送消息服务
 * @author havo
 * @date 2021/11/19 10:46
 * @copyright 小码科技
 */

namespace Sszzai\MicroService;

interface PushServiceInterface
{

    /**
     * 推送离线聊天消息
     * @param array $msg
     * @return mixed
     */
    public function pushChatMsg($msg);


    /**
     * 告警
     * @param $msg
     * @return mixed
     */
    public function alert($msg);

    /**
     * 推送设备注册
     * @param int $appid 应用ID
     * @param string $type 推送平台类型
     * @param string $register_id 注册ID
     * @param int $user_id 用户ID
     * @param array params 其他参数
     */
    public function register($appid,$type,$register_id,$user_id=0,$params=[]);


    /**
     * 设备与用户解绑
     * @param string $type 推送平台
     * @param string $register_id 注册ID
     * @param int $user_id 用户ID
     * @return mixed
     */
    public function unbind($type,$register_id,$user_id);


}