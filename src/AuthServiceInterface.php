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

    public function access(string $appkey);

    public function sign(string $sign,array $data);



}