<?php
//
define("TOKEN", "waiting4bus");
 

$wechatObj = new wechatCallbackapiTest();
error_log(date("[Y-m-d H:i:s]")."-init wechatobj\n", 3, "/tmp/wechat.log");
if( isset($_REQUEST['echostr']) )
{
  $wechatObj->valid(); 
 }
elseif( isset( $_REQUEST['signature'] ) )
{ 
  include 'processor.php';
  $wechatObj->responseMsg();
}

class wechatCallbackapiTest
{
  public function valid()
    {
        $echoStr = $_GET["echostr"];
        //valid signature , option
        if($this->checkSignature()){
          echo $echoStr;
          exit;
        }
    }

    public function responseMsg()
    {
    //get post data, May be due to the different environments
    $postStr = $GLOBALS["HTTP_RAW_POST_DATA"]; 
    if (!empty($postStr)){ 
		$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
		$fromUsername = $postObj->FromUserName;
		$toUsername = $postObj->ToUserName;
		$keyword = trim($postObj->Content); 
    if(!empty( $keyword ))
		 {   
         processKeyword($fromUsername,$toUsername,$keyword);
    
    }else{ 
       echo "请输入查询关键字";
                }

        }

        else {
          echo "";
          exit;
        }
    }
    
  private function checkSignature()
  {
    $signature = $_GET["signature"];
    $timestamp = $_GET["timestamp"];
    $nonce = $_GET["nonce"];  
            
    $token = TOKEN;
    $tmpArr = array($token, $timestamp, $nonce);
    sort($tmpArr);
    $tmpStr = implode( $tmpArr );
    $tmpStr = sha1( $tmpStr );
    
    if( $tmpStr == $signature ){
      return true;
    }else{
      return false;
    }
  }
} 
?>