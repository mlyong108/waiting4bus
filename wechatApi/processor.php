<?php
define('BUSLINE_URI', 'http://218.28.136.21:8081/line.asp');
define('BUSGPS_URI', 'http://218.28.136.21:8081/gps.asp');
define('PIC_URI', 'http://bg.hntri.com/bus/img/');
define('BUSLINE_MAP_URI', 'http://bg.hntri.com/bus/showBusline.php');
 
include 'curlClass.php';

class MessageType
{
  const Txt=0;
  const News=1;
}
class LineType
{
  const Up=0;
  const Down=1;
}
//利用百度api生成静态图片
// function getBuslineImg($xl,$type)
// {
	// exec("phantomjs getBusline.js ".$xl.' '.$type); 
    // $fn=$xl.'-'.$type.'.png';
    // $path='./img/busline/'; 

// $im=imagecreatefrompng('/tmp/'.$fn);  
// $black = imagecolorallocate($im, 0x00, 0x00, 0x00);  
// imagefttext($im, 15, 0, 0, 20, $black, 'simhei.ttf', $xl.'路'.($type=='0'?'上行线路':'下行线路'));
// imagepng($im,'/tmp/'.$fn); 
// imagedestroy($im); 
// exec("pngcrush -rem alla -reduce /tmp/".$fn.' '.$path.$fn);
// }
function processKeyword($to,$from,$type,$keyword)
{
	$resultStr='';
	if ($type=='Location') {
		# code...
	}
	else
	{
	if($keyword=='dc')//候车
	{//直接刷新上次等车查询结果		
	
	}
	else if($keyword='')
	{//

	}
	else {
	  //只输入线路的情况

	}
   }
 error_log(date("[Y-m-d H:i:s]").$resultStr."\n", 3, "/tmp/wechat.log");	
 header('Content-Type: application/xml');
 echo $resultStr;
	
}
function queryGpsLine($xl,$type)
{
$curl = new curlClass(); 
//获取站点名称，以后可以考虑使用数据库本地存储
$data=$curl->get(BUSLINE_URI, array('xl'=>$xl,'ref'=>'0'));  
$data=strip_tags(mb_strstr($data,'上行线路：',false,'utf-8'));  
$line= mb_strstr($data,'下行线路：',$type==0?true:false,'utf-8');
$line=mb_substr($line,5,mb_strlen($line,'utf-8')-5,'utf-8'); 
 //转为数组
$stations=mb_split('--', $line); 
$stationsNum=count($stations);
error_log($stationsNum);
$lastStation=$stations[$stationsNum-1];
$result='选择候车站点：';
for ($i=0; $i < $stationsNum ; $i++) { 	
	$result.=sprintf('--<a href="%s?xl=%s%s&ud=%s&sno=%s&ref=4">%s</a>',
		BUSGPS_URI,$xl,urlencode('路'),$type,$i,$stations[$i]); 
} 
return $result;
}
function queryBusLine($xl)
{
//从公交公司站点查询，暂时弃用	
$curl = new curlClass(); 
$data=$curl->get(BUSLINE_URI, array('xl'=>$xl,'ref'=>'0'));  
$data=strip_tags(mb_strstr($data,'上行线路：',false,'utf-8'));  
$superLine= mb_ereg_replace('--', '|',mb_strstr($data,'下行线路：',true,'utf-8'));
$superLine=mb_substr($superLine,5,mb_strlen($superLine,'utf-8')-5,'utf-8');
$subLine= mb_ereg_replace('--', '|',mb_strstr($data,'下行线路：',false,'utf-8'));
$subLine=mb_substr($subLine,5,mb_strlen($subLine,'utf-8')-5,'utf-8');
return '上行：'.$superLine.'<a href="http://bg.hntri.com/bus/showBusline.php?type=0&xl='.$xl.'">(查看地图)</a>  下行:'
.$subLine.'<a href="http://bg.hntri.com/bus/showBusline.php?type=1&xl='.$xl.'">(查看地图)</a>'; 
}
function responXml($to,$from,$content,$msgType)
{
		$msgTplHeader = sprintf("<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime>",
			$to,$from,time()); 
		switch($msgType)
		{
		    case MessageType::Txt:
			$xml=$msgTplHeader.sprintf("<MsgType><![CDATA[%s]]></MsgType><Content><![CDATA[%s]]></Content><FuncFlag>0</FuncFlag>",
				'text',$content);
			break;
			case MessageType::News:
			ob_start(); 
			?> 
			<MsgType><![CDATA[news]]></MsgType>
			<Content><![CDATA[]]></Content>
			<ArticleCount><?=count($content)?></ArticleCount>
			<Articles>
			<?php foreach( $content as $item ): ?>
			<item>
				<Title><![CDATA[<?=$item['title']?>]]></Title>
				<Description><![CDATA[<?=$item['content']?>]]></Description>
				<PicUrl><![CDATA[<?=$item['pic']?>]]></PicUrl>
				<Url><![CDATA[<?=$item['url']?>]]></Url>
			</item>
		  <?php endforeach; ?>
	      </Articles>
          <FuncFlag>0</FuncFlag></xml><?php
         $xml = $msgTplHeader.ob_get_contents();
		 break;
		 
		} 
		return trim($xml);
}
 function queryStation($x,$y)
 {
	$curl=new curlClass();
	//转换坐标
	/*在from和to中填上相应的值就能转换。
	gps坐标的0
	google坐标的2
	baidu坐标的4
	得到的结果形式为：
	{“error”:0,”x”:”MTE2LjM1MTA3ODgzMDM=”,”y”:”MzkuOTgwOTIwNDEwMTU2″}x和y都经过了base64转换。*/
 //$data=$curl->get('http://api.map.baidu.com/ag/coord/convert?from=2&to=4&x=120.0904441&y=30.3056719', 
 	//array('from'=>'2','to'=>'4','x'=>$x,'y'=>$y));
 	  
 }
?>
