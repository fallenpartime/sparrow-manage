<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0,viewport-fit=cover">
    <title>投票提交回馈</title>
    <link rel="stylesheet" type="text/css" href="/assets/front/css/main.css">
</head>
<body>
    <div class="nofindPage">
        <img src="/assets/front/images/fankui.png" alt="">
        <p>{{ $content }}</p>
        <a href="@if(!empty($redirectUrl)){{ $redirectUrl }}@else javascript:go(-1)@endif">返回</a>
    </div>
</body>
</html>