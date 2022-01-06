<?php
/**
 * @desc 日志处理
 * @date 2021/12/21 17:25
 * @copyright 小码科技
 */
namespace Sszzai\Service;

use Sszzai\Config\Config;
use Sszzai\Constant\ApiConstant;
use Sszzai\Exceptions\SszzaiException;
use Sszzai\Tool\HttpClient;
use Sszzai\Tool\Sign;
use Sszzai\Tool\SwooleClient;

class Log
{

    protected $config ;

    public function __construct($config){
        if(empty($config)){
            throw new SszzaiException("配置文件不能为空");
        }
        if(empty($config['url'])){
            throw new SszzaiException("api地址不能为空");
        }
        if(empty($config['appkey']) || empty($config['secret']) ){
            throw new SszzaiException("appkey和secret不能为空");
        }
        $this->config = new Config($config);
    }


    /**
     * 日志记录
     * @param $title  日志标签
     * @param $data 数据
     * @param string $level 报警级别 info,debug,warn,error,fatal
     * @param int $alert 1=发送报警
     * @return string|null
     * @throws SszzaiException
     */
    public function record($title,$data=[],$level="info",$alert=0){
        if(empty($title)){
            throw new SszzaiException("日志标题不能为空");
        }
        $param = [
            "type"=>$level,
            'title'=>$title,
            'alert'=>$alert,
            'data'=> json_encode($data)
        ];
        list($url,$api) = $this->config->getUrl(ApiConstant::LOG_RECORD_API);
        SwooleClient::post($url,$api,$param,[
            'appkey' => $this->config->getAppkey(),
            'sign' => Sign::getSign($param,$this->config->getSecret())
        ]);
    }


    /**
     * 流程日志
     * @param $type 业务类型
     * @param $step 当前步骤
     * @param $title 消息
     * @param array $data 数据
     * @param int $alert 1=是否报警
     * @return string|null
     * @throws SszzaiException
     */
    public function trace($type,$step,$title,$data=[],$alert=0){
        if(empty($type) || empty($step) || empty($title)){
            throw new SszzaiException("日志标题不能为空");
        }
        $param = [
            "type"=>$type,
            'step'=>$step,
            'title'=>$title,
            'alert'=>$alert,
            'data'=> json_encode($data)
        ];
        list($url,$api) = $this->config->getUrl(ApiConstant::LOG_TRACE_API);
        SwooleClient::post($url,$api,$param,[
            'appkey' => $this->config->getAppkey(),
            'sign' => Sign::getSign($param,$this->config->getSecret())
        ]);
    }
}