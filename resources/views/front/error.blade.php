<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0,viewport-fit=cover">
    <title></title>
    <link rel="stylesheet" type="text/css" href="/assets/front/css/main.css">
</head>
<body>
    <div class="nofindPage">
        <img src="/assets/front/images/404.png" alt="">
        <p>{{ $msg }}</p>
        <a href="@if(!empty($url)){{ $url }}@else javascript:go(-1)@endif">返回</a>
    </div>
</body>
</html>
