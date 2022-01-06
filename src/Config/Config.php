<?php
/**
 * @desc 配置管理
 * @date 2021/12/17 15:30
 * @copyright 小码科技
 */
namespace Sszzai\Config;
use Sszzai\Constant\ApiConstant;

class Config
{
    private $config;

    public function getUrl($api,$ver=""){
        $ver = !empty($ver)?$ver:ApiConstant::API_VERSION;
        $url = rtrim($this->config['url'],"/");
        $api = "/{$ver}".$api;
        return [$url,$api];
    }



    public function __construct($config){
        $this->config = $config;
    }

    /**
     * @return mixed
     */
    public function getAppkey()
    {
        return isset($this->config['appkey'])?$this->config['appkey']:"";
    }




    /**
     * @return mixed
     */
    public function getSecret()
    {
        return isset($this->config['secret'])?$this->config['secret']:"";
    }



    /**
     * @return mixed
     */
    public function getLog()
    {
        return isset($this->config['log'])?$this->config['log']:"";
    }






}