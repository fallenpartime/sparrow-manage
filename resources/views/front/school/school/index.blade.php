<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>学校搜索</title>
    <link rel="stylesheet" href="/assets/front/css/index.css">
    <link rel="stylesheet" type="text/css" href="/assets/front/css/shadow.css">
    <script src="/assets/javascripts/jquery-1.10.2.min.js" type="text/javascript"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</head>
<body>
<div class="main">
    <form action="">
        <label for="" class="serchBtn">
            <input type="text" placeholder="搜索学校" name='keyword' id="schoolName">
            <i class="submitBtn"></i>
        </label>
    </form>
    <div class="serResult" style="display: none;">
        <div class="result">搜索结果：</div>
        <div class="schooleList">
        </div>
    </div>
</div>
<script>
    $(function(){
        $('.submitBtn').click(function(){
            var schoolName = $("#schoolName").val();
            $.ajax({
                url:"{{ $check_url }}",
                type:"post",
                data:{keyword: schoolName},
                success:function(data){
                    var data = JSON.parse(data);
                    schoolList(data.result);
                },
                error:function(e){
                    alert("错误！！");
                }
            })
        });
    })
    function redirectMap(object) {
        object = $(object);
        location.href="{{ route('front.school.district.search') }}?topic="+object.attr('address-value');
    }
    function schoolList(data){
        $(".serResult").show();
        if(data.length>0){
            var html = '';
            $.each(data, function(index, item){
                html+='<div class="result-item list-shadow" address-value="'+item.name+'" onclick="redirectMap(this)">'+
                    '<h4>'+item.name+'</h4>'+
                    '<p class="item-address">地区：'+item.address+'</p>'+
                    '<p class="item-property">性质：'+item.property+'</p>'+
                    '<p class="item-phone">联系电话: '+item.telent+'</p>'+
                    '</div>'
            })
            $(".schooleList").html(html)
        }
    }
</script>
</body>
