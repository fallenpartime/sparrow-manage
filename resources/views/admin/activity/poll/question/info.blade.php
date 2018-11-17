@extends('admin.layouts.main')
@section('title', '网络投票活动配置-网络投票活动-活动管理中心')
@section('body_content')
    @include('admin.layouts.picture')
    <link href="/assets/stylesheets/common.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/assets/stylesheets/font-awesome.css" media="all" rel="stylesheet" type="text/css" />
    <script src="/assets/javascripts/WdatePicker.js" type="text/javascript"></script>
    @include('admin.menus.activity.poll_menu', ['menu' => $menu, 'admin_info' => $admin_info, 'ts_list' => $ts_list])
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
                        <div class="medical-box col-sm-10 col-md-10 col-lg-10" style="height: auto; padding-bottom: 5px;">
                            <p>
                                问题配置
                            </p>
                            <div class="medical-list" >
                                <div class="medical-div">
                                    <p style="width: 50%; display: inline; margin-right: 10px;">
                                        <span>活动ID:</span>
                                        <input type="text" name="activity_id" value="{{ !empty($activityId)? $activityId: '' }}" required="required" placeholder="请输入活动ID" style="width: 40%;"/>
                                    </p><br/>
                                    <p style="width: 100%; margin-right: 10px;">
                                        <span>问题类型:</span>
                                        <input type="radio" name="type" value="0" @if(!empty($record) && $record->type == 0) checked @endif />文字&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" name="type" value="1" @if(!empty($record) && $record->type == 1) checked @endif />图片
                                    </p><br/>
                                    <p style="width: 50%; display: inline; margin-right: 10px;">
                                        <span>问题标题:</span>
                                        <input type="text" name="title" value="{{ !empty($record)? $record->title: '' }}" placeholder="请输入问题标题" style="width: 40%;"/>
                                    </p><br/>
                                    <p style="margin-bottom: 0;float: left">
                                        <span>图片:</span>
                                    </p>
                                    <div id="list-container" style="overflow: hidden;width: 80%;float: left">
                                        <div id="list-up">
                                            <div id="utbtn-ipt"></div>
                                        </div>
                                    </div>
                                    <br/>
                                    <p style="width: 100%; margin-right: 10px;">
                                        <span>是否多选:</span>
                                        <input type="radio" name="is_checkbox" value="0" @if(!empty($record) && $record->is_checkbox == 0) checked @endif/>否&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" name="is_checkbox" value="1" @if(!empty($record) && $record->is_checkbox == 1) checked @endif/>是
                                    </p><br/><br/>
                                    <p id="answer" class="answer-list" style="width: 80%; margin-top: -10px; height: auto;">
                                        <span>问题答案：</span><br><br>
                                        <a id="add-item" class="add-item" href="javascript:;" style="cursor: pointer;@if($allowEditAnswer == 0) display: none;@endif">添加答案</a>
                                    </p>
                                    <p style="width: 100%;"></p><br/>
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
        @if(!empty($record) && !empty($record->source))
        initPictureList(uploadhandle, 'list-up', 'list_pic', '{{ $record->source }}', '{{ $record->source }}', 1);
        @endif
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
                            location.href='{{ $redirectUrl }}';
                        } else {
                            alert(result.msg)
                        }
                    }
                )
            }
        }
    </script>
    <script>
        function removeItem(object) {
            $(object).parent().remove();
        }
        var answerIndex = 1;
        function createAnswer(index, withDelete, value, answerId, allowEdit) {
            var delOption = '';
            var onlyReadOption = '';
            if (withDelete == 1 && allowEdit == 1 && index > 1) {
                delOption = '<a class="del-item" href="javascript:;" style="padding-left: 20px; cursor: pointer;" onclick="removeItem(this)">删除</a>\n';
            }
            if (allowEdit == 0) {
                onlyReadOption = 'readOnly';
            }
            $("#add-item").before('<div class="answer-item" style="display: block; padding-bottom: 10px;">\n' +
                '                                            <span>答案:</span>\n' +
                '                                            <input type="hidden" name="answer_id[' + index + ']" value="' + answerId + '" style="width: 50%;" />\n' +
                '                                            <input type="text" name="answer_title[' + index + ']" value="' + value + '" style="width: 50%;" ' + onlyReadOption + ' />\n' + delOption +
                '                                        </div>')
            answerIndex ++;
        }
        @if($allowEditAnswer == 1)
        $("#add-item").click(function () {
            createAnswer(answerIndex, 1, '', 0, 1)
        })
        @endif
        @if(!is_null($answers) && !$answers->isEmpty())
            @foreach($answers as $answer)
                createAnswer(answerIndex, 1, '{{ $answer->title }}', {{ $answer->id }}, {{ $allowEditAnswer }})
            @endforeach
        @else
        createAnswer(1, 0, '', 0, {{ $allowEditAnswer }})
        @endif
    </script>
@endsection
