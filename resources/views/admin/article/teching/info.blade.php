@extends('admin.layouts.main')
@section('title', '教研活动配置-教研活动-文章管理中心')
@section('body_content')
    @include('UEditor::head')
    @include('admin.layouts.picture')
    <link href="/assets/stylesheets/common.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/assets/stylesheets/font-awesome.css" media="all" rel="stylesheet" type="text/css" />
    <script src="/assets/javascripts/WdatePicker.js" type="text/javascript"></script>
    @include('admin.menus.article.teching_menu', ['menu' => $menu, 'admin_info' => $admin_info, 'ts_list' => $ts_list])
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
                    <form id="articleForm" action="" method="post" onsubmit="return false;">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ !empty($record)? $record->id: '' }}">
                        <input type="hidden" name="type" value="{{ $articleType }}" />
                        <div class="medical-box col-sm-10 col-md-10 col-lg-10" style="height: auto; padding-bottom: 5px;">
                            <p>
                                教研活动配置
                            </p>
                            <div class="medical-list">
                                <div class="medical-div">
                                    <p style="width: 50%; display: inline; margin-right: 10px;">
                                        <span>文章标题:</span>
                                        <input type="text" name="title" value="{{ !empty($record)? $record->title: '' }}" required="required" placeholder="请输入文章标题" style="width: 40%;"/>
                                    </p><br/><br/>
                                    <p style="width: 50%; display: inline; margin-right: 10px;">
                                        <span>文章作者:</span>
                                        <input type="text" name="author" value="{{ !empty($record)? $record->author: '' }}" required="required" placeholder="请输入文章作者" style="width: 40%;"/>
                                    </p><br/>
                                    <p style="width: 50%; margin-top: 20px; margin-right: 10px;">
                                        <span>文章简介:</span>
                                        <textarea name="description" required="required" placeholder="请输入文章简介">{{ !empty($record)? $record->description: '' }}</textarea>
                                    </p><br/>
                                    <p style="width: 100%;">
                                        <span>发布时间:</span>
                                        <input name="pubdate" type="text" class="Wdate" value="{{ !empty($record)? $record->published_at: '' }}" style="width: 160px;" onfocus="WdatePicker({isShowWeek:true,readOnly:'true',dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'2010-10-01 00:00:00',maxDate:'2099-12-31 23:59:59'})" />
                                    </p><br/>
                                    <p style="margin-bottom: 0;float: left">
                                        <span>列表图片:<font style="color: grey;">(图尺寸为：86*60)</font></span>
                                    </p>
                                    <div id="list-container" style="overflow: hidden;width: 80%;float: left">
                                        <div id="list-up">
                                            <div id="utbtn-ipt"></div>
                                        </div>
                                    </div>
                                    <p style="width: 100%;">
                                        <span style="width: 150px;">文章内容:</span>
                                        <textarea class="analysis" id="content" name="content" required="required" placeholder="请输入文章内容" style="width: 100%; padding: 0 10px;">{{ !empty($record)? $record->content: '' }}</textarea>
                                    </p><br/>

                                </div>
                            </div>
                        </div>

                        <p class="deposit">
                            <input type="submit" name="submit" value="保存" onclick="articleSave();"/>
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
            key      : 'list_pic'
        })
    </script>
    <script>
        @if(!empty($record) && !empty($record->list_pic))
        initPictureList(uploadhandle, 'list-up', 'list_pic', '{{ $record->list_pic }}', '{{ $record->list_pic }}', 1);
        @endif
    </script>
    <script type="text/javascript">
        var ue = UE.getEditor('content');
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
        });
    </script>
    <script>
        function articleSave() {
            if (confirm('确定提交？')) {
                $.post(
                    '{{ $actionUrl }}',
                    $('#articleForm').serialize(),
                    function (result) {
                        result = JSON.parse(result)
                        if (result.code == 200) {
                            location.href=document.referrer;
                        } else {
                            alert(result.msg)
                        }
                    }
                )
            }
        }
    </script>
@endsection
