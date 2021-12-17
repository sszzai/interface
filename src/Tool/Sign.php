<?php
/**
 * @desc
 * @date 2021/12/17 16:12
 * @copyright 小码科技
 */

namespace Sszzai\Tool;


class Sign{


    public  static  function getSign($data,$secret)
    {
        ksort($data);  //将数组 按Ascii 升序排列
        $tmp = [];
        foreach ($data as $k => $v) {
            $k = trim($k);    //去掉参数名空格
            if(is_array($v)){  //数组不参与签名
                continue;
            }
            $v = trim($v);   //去掉参数值空格
            $tmp[$k] = $v;
        }
        $tmp['key'] = $secret;   // 处理好的数据加上 密钥字段
        $before_str = urldecode(http_build_query($tmp));
        $sign_str =  urlencode($before_str);  //生成url query字符串
        return strtoupper(md5($sign_str));  //md5加密后并且将结果转换为大写
    }
}