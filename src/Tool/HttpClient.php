<?php

namespace Sszzai\Tool;

use Sszzai\Exceptions\SszzaiException;

class HttpClient {

    public static $log = 'http';

    /**
     * 执行一个GET请求
     * @param string $url
     * @param array $headers
     * @param int $timeout
     * @return string|null
     */
    public static function get($url,$data=[], $headers = [],$timeout = 5) {
        $ch = curl_init();
        if(!empty($data)){
            $url.="?".http_build_query($data);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($headers) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (substr($url, 0, 5) == 'https') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        $time_s = microtime(true);
        $content = curl_exec($ch);
        $time_e = microtime(true);
        $time = number_format($time_e - $time_s, 3);
        $response = curl_getinfo($ch);
        curl_close($ch);
        if(strpos($response['content_type'],"application/json")===0){
            $content = json_decode($content,true);
        }
        if ($response['http_code'] == 200) {
            return $content;
        }
        return null;
    }

    /**
     * 执行一个POST请求
     *
     * @param string $url
     * @param array $fields
     * @param array $headers
     * @param int $timeout
     *
     * @return string|null
     */
    public static function post($url, $fields,$headers = [], $timeout = 20) {
        if(is_array($fields)){
            $query = http_build_query($fields);
        }else{
            $query = $fields;
        }
//        $headers = $headers + array('Expect:');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (substr($url, 0, 5) == 'https') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        $time_s = microtime(true);
        $content = curl_exec($ch);
        $time_e = microtime(true);
        $time = number_format($time_e - $time_s, 3);
        $response = curl_getinfo($ch);
        $errno = curl_errno($ch);
        if ($errno) {
            $errMsg = curl_error($ch) . '[' .$errno . ']';
        }
        curl_close($ch);
        file_put_contents("./http.log",json_encode([
            "time"=>$time,
            "url"=>$url,
            'data'=>$fields,
            'header'=>$headers,
            'content'=>$content
        ]),FILE_APPEND);
        if($errno){
            throw new SszzaiException($errMsg);
        }
        if(strpos($response['content_type'],"application/json")===0){
            $content = json_decode($content,true);
        }
        if ($response['http_code'] == 200) {
            return $content;
        }
        return null;
    }

    public static function head($url, $timeout = 5) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }

    public static function request($url, $mode, $params = '', $needHeader = false, $timeout = 10, $header = array(), $headerOnly = false) {
        $begin = microtime(true);
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        if ($needHeader) {
            curl_setopt($curlHandle, CURLOPT_HEADER, true);
            curl_setopt($curlHandle, CURLINFO_HEADER_OUT, true);
            if ($headerOnly) {
                curl_setopt($curlHandle, CURLOPT_NOBODY, 1); //不需要body
            }
        }
        if ($mode == 'POST') {
            curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $header + array('Expect:'));
            curl_setopt($curlHandle, CURLOPT_POST, true);
            if (is_array($params)) {
                curl_setopt($curlHandle, CURLOPT_POSTFIELDS, http_build_query($params));
            } else {
                curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $params);
            }
        } else {
            if ($header) {
                curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $header);
            }
            if (is_array($params)) {
                $url .= (strpos($url, '?') === false ? '?' : '&') . http_build_query($params);
            } else {
                $url .= (strpos($url, '?') === false ? '?' : '&') . $params;
            }
        }
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        if (substr($url, 0, 5) == 'https') {
            curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, false);
        }
        $result = curl_exec($curlHandle);
        if ($needHeader) {
            $tmp = $result;
            $result = array();
            $info = curl_getinfo($curlHandle);
            $result['header'] = substr($tmp, 0, $info['header_size']);
            $result['body'] = trim(substr($tmp, $info['header_size'])); //直接从header之后开始截取，因为 1.body可能为空   2.下载可能不全
        }
        $errno = curl_errno($curlHandle);
        if ($errno) {
            if (is_array($params)) {
                $params = http_build_query($params);
            }
            $url .= (strpos($url, '?') === false ? '?' : '&') . $params;
            $errMsg = curl_error($curlHandle) . '[' . curl_errno($curlHandle) . ']';
        }
        curl_close($curlHandle);
        return $result;
    }

    public static function download($url) {
        $tmp_dir =   './runtime/tmp/';
        if (!is_dir($tmp_dir)) {
            mkdir($tmp_dir, 0777, true);
        }
        try {
            $curl = curl_init($url);
            $filename = $tmp_dir . basename($url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $data = curl_exec($curl);
            curl_close($curl);
            $tp = fopen($filename, 'a');
            fwrite($tp, $data);
            fclose($tp);
            return $filename;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function upload($url,$param,$token){
        $delimiter =  uniqid();
        $post_data = self::buildData($delimiter,$param);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Content-Type: multipart/form-data; boundary=" .$delimiter,
            $token,
            "Content-Length: " . strlen($post_data)
        ]);
        $time_s = microtime(true);
        $content = curl_exec($curl);
        $time_e = microtime(true);
        $response = curl_getinfo($curl);
        curl_close($curl);

        if(strpos($response['content_type'],"application/json")===0){
            $content = json_decode($content,true);
        }
        $time = number_format($time_e - $time_s, 3);
        if ($response['http_code'] == 200) {
            return $content;
        }
        return null;
    }

    private static function buildData($delimiter,$param){
        $data = '';
        $eol = "\r\n";
        $upload = $param['upload'];
        unset($param['upload']);
        foreach ($param as $name => $content) {
            $data .= "--" . $delimiter . "\r\n"
                . 'Content-Disposition: form-data; name="' . $name . "\"\r\n\r\n"
                . $content . "\r\n";
        }
        // 拼接文件流
        $data .= "--" . $delimiter . $eol
            . 'Content-Disposition: form-data; name="upload"; filename="' . $param['filename'] . '"' . "\r\n"
            . 'Content-Type:application/octet-stream'."\r\n\r\n";

        $data .= $upload . "\r\n";
        $data .= "--" . $delimiter . "--\r\n";
        return $data;
    }

}
