<?php
/**
 * @desc 配置管理
 * @date 2021/12/17 15:30
 * @copyright 小码科技
 */
namespace Sszzai\Config;
class Config
{
    private $appkey;
    private $secret;
    private $log;
    private $url ;

    public function getUrl(){
        return $this->url;
    }



    public function __construct($config){
        foreach ($config as $key=>$vo){
            $this->$key = $vo;
        }
    }

    /**
     * @return mixed
     */
    public function getAppkey()
    {
        return $this->appkey;
    }

    /**
     * @param mixed $appkey
     */
    public function setAppkey($appkey): void
    {
        $this->appkey = $appkey;
    }

    /**
     * @return mixed
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * @param mixed $secret
     */
    public function setSecret($secret): void
    {
        $this->secret = $secret;
    }

    /**
     * @return mixed
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * @param mixed $log
     */
    public function setLog($log): void
    {
        $this->log = $log;
    }





}