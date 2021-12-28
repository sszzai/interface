<?php
/**
 * @desc 日志处理
 * @date 2021/12/21 17:25
 * @copyright 小码科技
 */
namespace Sszzai\Service;

use Sszzai\Config\Config;
use Sszzai\Exceptions\SszzaiException;
use Sszzai\Tool\HttpClient;
use Sszzai\Tool\Sign;

class Log
{

    protected $config ;

    public function __construct($config){
        if(empty($config)){
            throw new SszzaiException("配置文件不能为空");
        }
        if(empty($config['appkey']) || empty($config['secret']) || empty($config['url'])){
            throw new SszzaiException("appkey和secret不能为空");
        }
        $this->config = new Config($config);
    }


    public function record($title,$data,$level="info"){
        if(empty($title)){
            throw new SszzaiException("日志标题不能为空");
        }
        $param = [
            "type"=>$level,
            'title'=>$title,
            'data'=> json_encode($data)
        ];
        return HttpClient::post($this->config->getUrl(),$param,[
            'appkey' => $this->config->getAppkey(),
            'sign' => Sign::getSign($param,$this->config->getSecret())
        ]);
    }
}