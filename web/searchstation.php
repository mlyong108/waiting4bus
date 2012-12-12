<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
body, html,#allmap {width: 100%;height: 100%;overflow: hidden;margin:0;}
#l-map{height:100%;width:78%;float:left;border-right:2px solid #bcbcbc;}
#r-result{height:100%;width:20%;float:left;}
</style>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4"></script>
<title>圆形区域搜索</title>
</head>
<body>
<div id="allmap"></div>
</body>
</html>
<script type="text/javascript">
var map = new BMap.Map("allmap");            // 创建Map实例
var mPoint = new BMap.Point(113.673, 34.768);  
map.enableScrollWheelZoom();
map.centerAndZoom(mPoint,15);

  var circle = new BMap.Circle(mPoint,200,{fillColor:"blue", strokeWeight: 1 ,fillOpacity: 0.3, strokeOpacity: 0.3});
    map.addOverlay(circle);
    var local =  new BMap.LocalSearch(map, {renderOptions: {map: map, autoViewport: false}});  
    var bounds = getSquareBounds(circle.getCenter(),circle.getRadius());
     local.searchInBounds("公交车站",bounds); 
   
    /**
     * 得到圆的内接正方形bounds
     * @param {Point} centerPoi 圆形范围的圆心
     * @param {Number} r 圆形范围的半径
     * @return 无返回值   
     */ 
    function getSquareBounds(centerPoi,r){
        var a = Math.sqrt(2) * r; //正方形边长
      
        mPoi = getMecator(centerPoi);
        var x0 = mPoi.x, y0 = mPoi.y;
     
        var x1 = x0 + a / 2 , y1 = y0 + a / 2;//东北点
        var x2 = x0 - a / 2 , y2 = y0 - a / 2;//西南点
        
        var ne = getPoi(new BMap.Pixel(x1, y1)), sw = getPoi(new BMap.Pixel(x2, y2));
        return new BMap.Bounds(sw, ne);        
        
    }
    //根据球面坐标获得平面坐标。
    function getMecator(poi){
        return map.getMapType().getProjection().lngLatToPoint(poi);
    }
    //根据平面坐标获得球面坐标。
    function getPoi(mecator){
        return map.getMapType().getProjection().pointToLngLat(mecator);
    }
</script>


 