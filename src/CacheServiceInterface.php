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

    public function getAppCache(string $appkey);
    public function setAppCache(string $appkey,array $data);
    public function deleteAppCache(string $appkey);



}