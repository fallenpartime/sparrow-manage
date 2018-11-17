<!DOCTYPE html>
<html>
<head>
    <!-- <link href="//fonts.googleapis.com/css?family=Lato:100,300,400,700" media="all" rel="stylesheet" type="text/css" /> -->
    <link href="/assets/stylesheets/bootstrap.min.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/assets/stylesheets/font-awesome.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/assets/stylesheets/se7en-font.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/assets/stylesheets/style.css" media="all" rel="stylesheet" type="text/css" />
    <script src="/assets/javascripts/jquery-1.10.2.min.js" type="text/javascript"></script>
    <script src="/assets/javascripts/jquery-ui.js" type="text/javascript"></script>
    <script src="/assets/javascripts/bootstrap.min.js" type="text/javascript"></script>
    <script src="/assets/javascripts/modernizr.custom.js" type="text/javascript"></script>
    <script src="/assets/javascripts/main.js" type="text/javascript"></script>
    <script src="/assets/javascripts/application.js" type="text/javascript"></script>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
</head>
<body class="fourofour">
<!-- Login Screen -->
<div class="fourofour-container">
    <h1>!!!</h1>
    <h2>{{ $message }}</h2>
    <a class="btn btn-lg btn-default-outline" href="{{ route('index') }}">
        <i class="icon-home"></i>主页
    </a>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a class="btn btn-lg btn-default-outline" href="javascript:history.back(-1);">
        <i class="icon-hand-left"></i>返回
    </a>
</div>
<!-- End Login Screen -->
</body>

</html>