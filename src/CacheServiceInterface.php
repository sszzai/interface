<?php

/**
 * @desc 缓存接口
 * @author havo
 * @date 2021/11/15 11:48
 * @copyright 小码科技
 */
namespace Sszzai\MicroService;

interface CacheServiceInterface
{

    /**
     * 获取应用缓存
     * @param string $appkey 客户端key
     * @return mixed
     */
    public function getAppCache(string $appkey);
    /**
     * 设置应用缓存，不支持
     * @param string $appkey 客户端key
     * @param array $data 数据
     * @return mixed
     */
    public function setAppCache(string $appkey,array $data);

    /**
     * 删除缓存
     * @param string $appkey 客户端key
     * @return mixed
     */
    public function deleteAppCache(string $appkey);


    /**
     * 根据用户ID获取用户token信息
     * @param $user_id 用户ID
     * @return mixed
     */
    public function getUserTokenCache($user_id);

}