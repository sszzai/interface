<?php
/**
 * @desc 缓存接口
 * @author havo
 * @date 2021/11/15 11:48
 * @copyright 小码科技
 */
namespace Sszzai\MicroService;

interface AuthServiceInterface
{
    /**
     * 授权检测（检测客户端是否有权限进入）
     * @param string $appkey 平台下发给客户端的应用key
     * @return mixed
     */
    public function access(string $appkey);

    /**
     * 签名检测
     * @param string $sign 客户端签名字符串
     * @param array $data 待签名数据
     * @param string $appkey 应用appkey
     * @return mixed
     */
    public function sign(string $sign,array $data,string $appkey);

    /**
     * 用户登陆检测，检测用户当前状态
     * @param $token 登陆后的token
     * @param $token 登陆后的token
     * @param $uid 用户ID
     * @return mixed
     */
    public function checkLogin(string $appkey,string $token,$uid);


}