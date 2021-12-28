<?php
/**
 * @desc 报警处理
 * @date 2021/12/17 15:23
 * @copyright 小码科技
 */
namespace Sszzai\Service;

use Sszzai\Config\Config;
use Sszzai\Constant\ApiConstant;
use Sszzai\Exceptions\SszzaiException;
use Sszzai\Tool\HttpClient;
use Sszzai\Tool\Sign;

class Alert
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


    /**
     * 告警
     * @param $event 事件类型
     * @param $content 报警详情
     * @param string $level 只支持：info=通知，warn=警告，error=一般错误，fatal=严重错误
     * @param string $suggest 操作建议
     */
    public function report($event,$content,$level="info",$suggest=''){
        if(empty($event) || empty($content)){
            throw new SszzaiException("报警事件或者内容不能为空");
        }
        $data = [
            "noncestr"=>uniqid(),
            'time'=>time(),
            "event_type"=>$event,
            'content'=>$content,
            'level'=>$level,
            'suggest'=>$suggest
        ];
        return HttpClient::post($this->config->getUrl(ApiConstant::ALERT_API),$data,[
            'appkey' => $this->config->getAppkey(),
            'sign' => Sign::getSign($data,$this->config->getSecret())
        ]);
    }



}