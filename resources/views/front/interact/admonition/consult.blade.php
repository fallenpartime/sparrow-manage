<html>
<head>
    <title>添加意见</title>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0,viewport-fit=cover">
    <link rel="stylesheet" type="text/css" href="/assets/front/css/main.css">
    <link rel="stylesheet" type="text/css" href="/assets/front/css/suggestion.css">
    <link rel="stylesheet" type="text/css" href="/assets/front/css/iconfont.css">
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</head>
<body>
<div class="container">
    <div class="main">
        <div class="sug-title">互动意见提交</div>
        <div class="panel">
            <div class="panel-title">意见反馈</div>
            <div class="panel-body">
                <form action="" method="post" onsubmit="return false;" id="form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <label class="form-label">姓名:</label>
                        <input class="input-text" type="text" name="name" value="">
                    </div>
                    <div class="row">
                        <label class="form-label">手机:</label>
                        <input class="input-text" type="text" name="phone" value="">
                    </div>
                    <div class="row">
                        <label class="form-label">意见:</label>
                        <textarea name="idea"></textarea>
                    </div>
                    <input class="sub-btn" type="submit" value="提&nbsp;&nbsp;&nbsp;交">
                </form>
            </div>
        </div>
    </div>
    <div class="alert" style="display: none;">
        提交成功
    </div>
</div>
</body>
<script src="/assets/javascripts/jquery-1.10.2.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function(){
        $(".sub-btn").click(function(){
            $.post(
                '{{ $submit_url }}',
                $("#form-data").serialize(),
                function (result) {
                    result = JSON.parse(result)
                    if (result.code==200) {
                        $(".alert").html('提交成功');
                        $(".alert").show();
                        setTimeout(function(){
                            $(".alert").css("display","none");
                            location.href="{{ $redirectUrl }}";
                        }, 2000);
                    } else {
                        $(".alert").html(result.msg);
                        $(".alert").show();
                        setTimeout(function(){
                            $(".alert").css("display","none");
                        }, 2000);
                    }
                }
            );
        });
    });
</script>
</html>
