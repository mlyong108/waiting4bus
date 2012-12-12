<!DOCTYPE html><!--HTML5 doctype-->
<html>
<head>
<title>线路查询结果</title>
<meta http-equiv="Content-type" content="text/html; charset=utf-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="apple-mobile-web-app-capable" content="yes" />
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">  
<link rel="stylesheet" type="text/css" href="../jqmobile/kitchensink/icons.css" />  
<link rel="stylesheet" type="text/css" href="../jqmobile/kitchensink/jq.ui.less.css" title="default"/>

<style>
	.scrollBar{background:white;} 
    ul.iconLinks li {font-size:12px; font-weight:normal;} 
	.jqmscrollBar {background:white !important;}	
</style> 
 
<script type="text/javascript" charset="utf-8" src="../jqmobile/jq.mobi.js"></script> 
<!-- include jq.desktopBrowsers.js on desktop browsers only -->
<script> 
if(!((window.DocumentTouch&&document instanceof DocumentTouch)||'ontouchstart' in window)){
	var script=document.createElement("script");
	script.src="../jqmobile/plugins/jq.desktopBrowsers.js";
	var tag=$("head").append(script);
	if(!$.os.ie){ 
	}
}
var oldElem="default";
function setActiveStyleSheet(title) {
   var a = document.getElementsByTagName("link");
   var currElem;
   
   if(title==oldElem.getAttribute("title")||oldElem=="default")
      return;
   for(i=0; i<a.length; i++) {
   
       if(a[i].getAttribute("title")==title){
         currElem=a[i];
       }
       else if(!a[i].getAttribute("disabled")&&a[i].getAttribute("title"))
          oldElem=a[i];
   }
   
   currElem.removeAttribute("disabled");
   jq.ui.showMask();
   window.setTimeout(function(){
      jq.ui.hideMask();
      oldElem.setAttribute("disabled","true");
   },500);
}
$(document).ready(function(){
oldElem=document.getElementsByTagName("link")[0];
});


</script>
 
<script type="text/javascript" charset="utf-8" src="../jqmobile/ui/jq.ui.js"></script> 
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4"></script> 

<script type="text/javascript">
    /* This function runs once the page is loaded, but appMobi is not yet active */
	var webRoot="../jqmobile/kitchensink/";
	$.ui.autoLaunch=true;
    $.ui.openLinksNewTab=false;
    $.ui.resetScrollers=false;
    var init = function(){
	   $.ui.backButtonText="Back";  
	   //window.setTimeout(function(){$.ui.launch();},1500);
       //$.ui.removeFooterMenu(); This would remove the bottom nav menu
    };
    document.addEventListener("DOMContentLoaded",init,false);  
	$.ui.ready(function(){ 
	var map = new BMap.Map("main");
	var busline = new BMap.BusLineSearch('郑州',{
        renderOptions:{map:map,panel:'',autoViewport:true},
        onGetBusListComplete: function(result){
           if(result){ 
             var busLine= result.getBusListItem('<?=$_GET["type"]?>');
             busline.getBusLine(busLine);  
           }
        },
        onMarkersSet: function(result){
        window.setTimeout(function(){$('#navbar').append("<div id='done'></div>");},1500);
        }  
});  
    busline.getBusList("<?=$_GET['xl']?>");
	 $.ui.toggleHeaderMenu(false);
	});

    /* This code is used to run as soon as appMobi activates */
    var onDeviceReady=function(){
		AppMobi.device.setRotateOrientation("portrait");
        AppMobi.device.setAutoRotate(false);
		webRoot=AppMobi.webRoot+"kitchensink/";
	    //hide splash screen
	    AppMobi.device.hideSplashScreen();	
	    $.ui.blockPageScroll(); //block the page from scrolling at the header/footer
		
    };
    document.addEventListener("appMobi.device.ready",onDeviceReady,false);    
 
</script> 
</head>
<body>
<div id="jQUi">
<!-- this is the splashscreen you see. -->
 
    <div id="header"> 
    </div>

<div id="content">
	<div title="<?php echo ($_GET['xl'].'路'.($_GET['type']=='0'?'上行线路':'下行线路'))?>" id="main" class="panel" selected="true">
	
	</div> 
</div> 
<div id="navbar" style='margin: 0;float:left;'>
    <!--<a href="#main" id='navbar_home' class='icon home' >home</a> -->
</div>  
</div>
</body>
</html>