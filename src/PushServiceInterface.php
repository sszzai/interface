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
     * 报警
     * @param $event_type 事件标识 参考数据库 cmf_alert_event
     * @param $content 内容
     * @param $level 等级 只支持：info=通知，warn=警告，error=一般错误，fatal=严重错误
     * @param $suggest 修复建议
     * @return mixed
     */
    public function alert($event_type,$content,$level='warn',$suggest='');


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