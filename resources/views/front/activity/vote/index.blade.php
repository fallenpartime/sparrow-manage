<html>
<head>
    <title>活动投票</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0,viewport-fit=cover">
    <link rel="stylesheet" type="text/css" href="/assets/front/css/main.css">
    <link rel="stylesheet" type="text/css" href="/assets/front/css/suggestion.css">
    <link rel="stylesheet" type="text/css" href="/assets/front/css/iconfont.css">
    <script src="/assets/javascripts/jquery-1.10.2.min.js" type="text/javascript"></script>
</head>
<body>
<div class="container">
    <div class="main">
        <div class="sug-title">{{ array_get($record, 'title') }}</div>
        <form action="" method="" id="vote-form">
            {{ csrf_field() }}
            @foreach($questions as $question)
            <div class="panel vote-panel">
                <div class="panel-title">@if($question->type==0){{ $question->title }}@else<img src="{{ $question->source }}" style="width: 100%; height: 60px;"/>@endif</div>
                <div class="vote-type">
                    @if(!is_null($question->answers))
                        @foreach($question->answers as $answer)
                            <label for="" class="vote-item">
                                @if($question->is_checkbox)
                                    <input type="checkbox" name="answer_box[]" value="{{ "{$question->id}-{$answer->id}" }}" /><span></span>{{ $answer->title }}
                                @else
                                    <input type="radio" name="answer_single[{{ $question->id }}]" value="{{ "{$question->id}-{$answer->id}" }}" /><span></span>{{ $answer->title }}
                                @endif
                            </label>
                        @endforeach
                        <label for=""  class="vote-item">
                            <input type="checkbox" value="其他" class="other"><span></span>其他
                            <input type="text" name="answer_other[{{ $question->id }}]" class="oContent" placeholder="请填写其他选项">
                        </label>
                    @endif
                </div>
            </div>
            @endforeach
            <a href="javascript:void(0)" class="sub-btn">提交</a>
        </form>
    </div>
    <div class="alert" style="display: none">
        提交成功
    </div>
</div>
</body>
<script>
    $(function(){
        $('.sub-btn').click(function(){
            $.ajax({
                url:"{{ $vote_url }}",
                type:"post",
                data: $("#vote-form").serialize(),
                success:function(data){
                    data = JSON.parse(data)
                    location.href = data.data.url;
                },
                error:function(e){
                    alert("错误！！");
                }
            })
        })
        $(".other").click(function(){
            console.log($(this));
            var a = $(this).parent('label').find('.oContent');
            a.toggle();
        })
    })
</script>
</html>