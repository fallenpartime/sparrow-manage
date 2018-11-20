<!DOCTYPE html>
<html>
<head>
    <title>登录</title>
    <!-- <link href="//fonts.googleapis.com/css?family=Lato:100,300,400,700" media="all" rel="stylesheet" type="text/css" /> -->
    <link href="/assets/stylesheets/bootstrap.min.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/assets/stylesheets/se7en-font.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/assets/stylesheets/font-awesome.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/assets/stylesheets/style.css" media="all" rel="stylesheet" type="text/css" />
    <script src="/assets/javascripts/jquery-1.10.2.min.js" type="text/javascript"></script>
    <script src="/assets/javascripts/jquery-ui.js" type="text/javascript"></script>
    <script src="/assets/javascripts/bootstrap.min.js" type="text/javascript"></script>
    <script src="/assets/javascripts/raphael.min.js" type="text/javascript"></script>
    <script src="/assets/javascripts/jquery.mousewheel.js" type="text/javascript"></script>
    <script src="/assets/javascripts/jquery.vmap.min.js" type="text/javascript"></script>
    <script src="/assets/javascripts/jquery.vmap.sampledata.js" type="text/javascript"></script>
    <script src="/assets/javascripts/jquery.vmap.world.js" type="text/javascript"></script>
    <script src="/assets/javascripts/jquery.bootstrap.wizard.js" type="text/javascript"></script>
    <script src="/assets/javascripts/fullcalendar.min.js" type="text/javascript"></script>
    <script src="/assets/javascripts/gcal.js" type="text/javascript"></script>
    <script src="/assets/javascripts/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="/assets/javascripts/datatable-editable.js" type="text/javascript"></script>
    <script src="/assets/javascripts/jquery.easy-pie-chart.js" type="text/javascript"></script>
    <script src="/assets/javascripts/excanvas.min.js" type="text/javascript"></script>
    <script src="/assets/javascripts/jquery.isotope.min.js" type="text/javascript"></script>
    <script src="/assets/javascripts/masonry.min.js" type="text/javascript"></script>
    <script src="/assets/javascripts/modernizr.custom.js" type="text/javascript"></script>
    <script src="/assets/javascripts/jquery.fancybox.pack.js" type="text/javascript"></script>
    <script src="/assets/javascripts/select2.js" type="text/javascript"></script>
    <script src="/assets/javascripts/styleswitcher.js" type="text/javascript"></script>
    <script src="/assets/javascripts/wysiwyg.js" type="text/javascript"></script>
    <script src="/assets/javascripts/jquery.inputmask.min.js" type="text/javascript"></script>
    <script src="/assets/javascripts/jquery.validate.js" type="text/javascript"></script>
    <script src="/assets/javascripts/bootstrap-fileupload.js" type="text/javascript"></script>
    <script src="/assets/javascripts/bootstrap-datepicker.js" type="text/javascript"></script>
    <script src="/assets/javascripts/bootstrap-timepicker.js" type="text/javascript"></script>
    <script src="/assets/javascripts/bootstrap-colorpicker.js" type="text/javascript"></script>
    <script src="/assets/javascripts/bootstrap-switch.min.js" type="text/javascript"></script>
    <script src="/assets/javascripts/daterange-picker.js" type="text/javascript"></script>
    <script src="/assets/javascripts/date.js" type="text/javascript"></script>
    <script src="/assets/javascripts/morris.min.js" type="text/javascript"></script>
    <script src="/assets/javascripts/skycons.js" type="text/javascript"></script>
    <script src="/assets/javascripts/jquery.sparkline.min.js" type="text/javascript"></script>
    <script src="/assets/javascripts/fitvids.js" type="text/javascript"></script>
    <script src="/assets/javascripts/main.js" type="text/javascript"></script>
    <script src="/assets/javascripts/respond.js" type="text/javascript"></script>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
</head>
<body class="login2">
<!-- Login Screen -->
<div class="login-wrapper">
    <div class="login-container">
        <a href="#"><img width="165" height="40" src="/assets/public/img/logo.png" /></a>

        <div class="form-group">
            <div style="text-align:center;margin:0 auto" id="login_container">
                {!! QrCode::size(300)->generate($code_url); !!}
            </div>
        </div>

        <p class="signup">
            请使用<a href="#">微信</a>扫描二维码登录
        </p>
    </div>
</div>

<script>
    $(function(){
        checkstatus = function(url) {
            $.getJSON(url, function(res){
                console.log(res);
                if (res.code == 200) {
                    window.location.href = res.data.url;
                }
            });
        };
        setInterval(function() {
            checkstatus("{{ $check_url }}")
        }, 5000);
    });
</script>

<!-- End Login Screen -->
</body>

</html>