@extends('admin.layouts.main')
@section('title', '教育新闻详情-教育新闻-文章管理中心')
@section('body_content')
    @include('UEditor::head')
    @include('admin.layouts.picture')
    <link href="/assets/stylesheets/common.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/assets/stylesheets/font-awesome.css" media="all" rel="stylesheet" type="text/css" />
    <script src="/assets/javascripts/WdatePicker.js" type="text/javascript"></script>
    @include('admin.menus.article.news_menu', ['menu' => $menu, 'admin_info' => $admin_info, 'ts_list' => $ts_list])
    <style>
        #list-up {
            width: 100px;
            height: 100px;
        }
    </style>
    <div class="container-fluid main-content">
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-lg-12">
                <div class="widget-container fluid-height clearfix search-window">
                    <form action="" method="post" onsubmit="return false;">
                        <div class="medical-box col-sm-10 col-md-10 col-lg-10" style="height: auto; padding-bottom: 5px;">
                            <p>
                                文章配置
                            </p>
                            <div class="medical-list">
                                <div class="medical-div">
                                    <p style="width: 50%; display: inline; margin-right: 10px;">
                                        <span>文章标题:</span>
                                        <input type="text" name="title" value="" required="required" placeholder="请输入文章标题" style="width: 40%;"/>
                                    </p>
                                    <p style="width: 100%; margin-top: 20px;">
                                        <span>发布时间:</span>
                                        <input name="pubdate" type="text" class="Wdate" id="sdt1" value="" style="width: 160px;" onfocus="WdatePicker({isShowWeek:true,readOnly:'true',dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'2010-10-01 00:00:00',maxDate:'2099-12-31 59:59:59'})" />
                                    </p><br/>
                                    <p style="margin-bottom: 0;float: left">
                                        <span>头图:<font style="color: grey;">(文章要设置为热文需上传头图，头图尺寸为：86*60)</font></span>
                                    </p>
                                    <div id="list-container" style="overflow: hidden;width: 80%;float: left">
                                        <div id="list-up">
                                            <div id="utbtn-ipt"></div>
                                        </div>
                                    </div>
                                    <p style="width: 100%;">
                                        <span style="width: 150px;">文章内容:</span>
                                        <textarea class="analysis" id="content" name="content" style="width: 100%; padding: 0 10px;"></textarea>
                                    </p><br/>

                                </div>
                            </div>
                        </div>

                        <p class="deposit">
                            <input type="hidden" name="id" value="">
                            <input type="submit" name="submit" value="保存" />
                        </p>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <script>
        var uploadhandle = new ImgUploader({
            handler  : 'list-up',
            target   : 'utbtn-ipt',
            container: 'list-container',
            url      : uploadUrl,
            imgNum   : 1,
            key      : 'main_files'
        })
    </script>
    <script>
        // initPictureList(uploadhandle, 'container', 'main_files', 'http://static.huijiayi.com.cn/liwudao/upload/image/20180928/7869849425.jpg', 'http://static.huijiayi.com.cn/liwudao/upload/image/20180928/7869849425.jpg', 1);
        // initPictureList(uploadhandle, 'container', 'main_files', 'http://static.huijiayi.com.cn/liwudao/upload/image/20180928/7869849425.jpg', 'http://static.huijiayi.com.cn/liwudao/upload/image/20180928/7869849425.jpg', 1);
    </script>
    <script type="text/javascript">
        var ue = UE.getEditor('content');
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
        });
    </script>
@endsection
