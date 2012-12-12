<?php 
/** 
* CURL基本类,包含get方式及POST方式 
* 
* @author  gster
* @date    2012-12-5 
*/ 
class curlClass 
{ 
    public function get($url, $params) 
    { 
        $ch = curl_init(); 
        // 设置 curl 相应属性 
        curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($params)); 
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        $returnTransfer = curl_exec($ch); 
        curl_close($ch); 
        return $returnTransfer; 
    }
    public function post($url, $params) 
    { 
        $ch = curl_init(); 
        // 设置 curl 相应属性 
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_POST, true); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params); 
        $returnTransfer = curl_exec($ch); 
        curl_close($ch); 
        return $returnTransfer; 
    } 
} 
// 测试代码 
//$curl = new curlClass(); 
//var_dump($curl->get(', array('a'=>'get','b'=>'1'))); 
//var_dump($curl->post(', array('a'=>'post','b'=>'2'))); 

?>
