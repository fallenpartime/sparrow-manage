<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0,viewport-fit=cover">
    <title>师生风采-详情</title>
    <link rel="stylesheet" type="text/css" href="/assets/front/css/main.css">
    <link rel="stylesheet" type="text/css" href="/assets/front/css/interaction.css">
    <link rel="stylesheet" type="text/css" href="/assets/front/css/iconfont.css">
    <title>学生家长互动</title>
</head>
<body>
<!-- https://www.jianshu.com/faqs -->
<div class="container">
    <div class="main">
        <div class="banner">
            <img src="/assets/front/images/banner.jpeg" alt="">
        </div>
        <div class="question-title">
            互动问题
            <a class="question-add" href="{{ $consult_url }}" title="咨询问题"><i class="iconfont">&#xe627;</i></a>
        </div>
        <ul class="question-list">
            @if(!$list->isEmpty())
                @foreach($list as $key => $item)
                    <li class="question-item">
                        <p class="title">问题{{ $key + 1 }}：{{ str_limit($item->content, 15, '...') }}<span>{{ $item->created_at->toDateString() }}</span></p>
                        <p class="con">{{ !empty($item->reply_content)? "答复：{$item->reply_content}": '' }}</p>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>
</body>
</html>
