<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style type="text/css">
        #allmap {height: 100vh;width:100%;}
    </style>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=BzhKkTniDZS9bPzFpLGTAG2UDSTocLHm"></script>
    <script src="/assets/javascripts/jquery-1.10.2.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/assets/front/css/main.css">
    <title>学区搜索</title>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</head>
<body>
    <div class="search">
        <label for="" class="mapSearch">
            <input type="text" value="{{ !empty($topic)? $topic: '' }}" id="topic" placeholder="请输入您要查询的学校">
            <!-- <button id="searchBtn" onclick="search()">搜索</button> -->
            <button id="searchBtn"></button>
        </label>
    </div>
    <div id="allmap"></div>
</body>
</html>
<script type="text/javascript">
    // 百度地图API功能
    var map = new BMap.Map("allmap");            // 创建Map实例
    map.centerAndZoom(new BMap.Point(120.38, 36.07), 11);
    map.enableScrollWheelZoom();
    map.addControl(new BMap.NavigationControl());  //添加默认缩放平移控件
    var checkUrl = "{{ route('front.school.district.search') }}";
    var infoList = {};
    function search() {
        map.clearOverlays();
        var school = $("#topic").val();
        $.post(
            checkUrl,
            {topic: school},
            function (response) {
                response = JSON.parse(response);
                for(var itemid in response.result){
                    //alert(data.data[item].longitude);
                    item = response.result[itemid]
                    var longitude=item.lng;
                    var latitude=item.lat;
                    if(longitude!=0 || latitude!=0){
                        point =new BMap.Point(longitude,latitude);
                        var content = '<div style="margin:0;line-height:20px;padding:2px;">' +
                            '名称：'+item.name+'<br/><hr>'+'地址：'+item.address+'<br/><hr>'+'电话：'+item.telent+'<br/><hr>'+'学区：'+item.district+'<br/><hr>'+'属性：' + item.property +
                            '<br/><hr></div>';
                        var windowInfo = new BMap.InfoWindow(content);
                        infoList[itemid] = windowInfo;
                        function addMarker(point){
                            var marker = new BMap.Marker(point);
                            map.addOverlay(marker);
                            marker.enableDragging();
                            marker.id = itemid
                            marker.addEventListener("click", function() {
                                this.openInfoWindow(infoList[this.id]);
                            })
                        }
                        addMarker(point);

                    }
                }//.for(
            }
        )
    }
    document.getElementById('searchBtn').addEventListener('click', search);
    @if(!empty($topic))
        search();
    @endif
</script>
