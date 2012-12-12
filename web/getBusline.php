<!--用于phantomjs生成图片-->
<!DOCTYPE html><!--HTML5 doctype-->
<html>
<head>
<title>线路查询结果</title>
<meta http-equiv="Content-type" content="text/html; charset=utf-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="apple-mobile-web-app-capable" content="yes" />
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">   
<link rel="stylesheet" type="text/css" href="kitchensink/jq.ui.less.css" title="default"/> 
<script type="text/javascript" charset="utf-8" src="./jq.mobi.js"></script>  
<script type="text/javascript" charset="utf-8" src="./ui/jq.ui.js"></script> 
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4"></script> 

<script type="text/javascript"> 
  var webRoot="./kitchensink/";
  $.ui.autoLaunch=true; 
    $.ui.resetScrollers=false;
    var init = function(){    
     $.ui.removeFooterMenu();  
    };
    document.addEventListener("DOMContentLoaded",init,false);  
  $.ui.ready(function(){ 
  var map = new BMap.Map("main");
  var busline = new BMap.BusLineSearch('郑州',{
        renderOptions:{map:map,panel:'',autoViewport:true},
        onGetBusListComplete: function(result){
           if(result){ 
             var busLine = result.getBusListItem('<?=$_GET["type"]?>');
             busline.getBusLine(busLine);  
           }
        },
        onMarkersSet: function(result){
        window.setTimeout(function(){$('#header').append("<div id='done'></div>");},1500);
        }  
});  
    busline.getBusList("<?=$_GET['xl']?>");
    $.ui.toggleHeaderMenu(false);
  });
 
    
 
</script> 
</head>
<body>
<div id="jQUi"> 
 
    <div id="header"> 
    </div>

<div id="content">
  <div title="<?php echo ($_GET['xl'].'路'.($_GET['type']=='0'?'上行线':'下行线'))?>" id="main" class="panel" selected="true">
  
  </div> 
</div> 
<div id="navbar" style='margin: 0;float:left;'>
    <!--<a href="#main" id='navbar_home' class='icon home' >home</a> -->
</div>  
</div>
</body>
</html>