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

    public function pushChatMsg($msg);

}