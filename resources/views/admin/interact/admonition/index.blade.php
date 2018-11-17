@extends('admin.layouts.main')
@section('title', '用户意见列表-用户意见管理-互动管理中心')
@section('body_content')
    <link href="/assets/stylesheets/common.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/assets/stylesheets/font-awesome.css" media="all" rel="stylesheet" type="text/css" />
    <script src="/assets/javascripts/WdatePicker.js" type="text/javascript"></script>
    @include('admin.menus.interact.admonition_menu', ['menu' => $menu, 'admin_info' => $admin_info, 'ts_list' => $ts_list])
    <div class="row" style="margin-bottom: 20px;margin-top: 20px;">
        <div class="col-lg-12">
            <div class="widget-container fluid-height clearfix search-window">
                <form action="">
                    <p class="about">
                        <span class="special">提交时间：</span>
                        <span>从</span>
                        <input name="from_time" type="text" class="Wdate"
                               onfocus="WdatePicker({isShowWeek:true,readOnly:'true',dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'2010-10-01 00:00:00',maxDate:'2099-12-31 59:59:59'})"
                               value="{{ array_get($urlParams, 'from_time') }}" style="width: 150px;"/>
                        <span>到</span>
                        <input name="end_time" type="text" class="Wdate"
                               onfocus="WdatePicker({isShowWeek:true,readOnly:'true',dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'2010-10-01 00:00:00',maxDate:'2099-12-31 59:59:59'})"
                               value="{{ array_get($urlParams, 'end_time') }}" style="width: 150px;"/>
                    </p>
                    <p class="about">
                        <span class="special">答复时间：</span>
                        <span>从</span>
                        <input name="from_reply_time" type="text" class="Wdate"
                               onfocus="WdatePicker({isShowWeek:true,readOnly:'true',dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'2010-10-01 00:00:00',maxDate:'2099-12-31 59:59:59'})"
                               value="{{ array_get($urlParams, 'from_reply_time') }}" style="width: 150px;"/>
                        <span>到</span>
                        <input name="end_reply_time" type="text" class="Wdate"
                               onfocus="WdatePicker({isShowWeek:true,readOnly:'true',dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'2010-10-01 00:00:00',maxDate:'2099-12-31 59:59:59'})"
                               value="{{ array_get($urlParams, 'end_reply_time') }}" style="width: 150px;"/>
                    </p>
                    <p class="inputs">
                        <span class="special">用户名：</span>
                        <input type="text" name="name" value="{{ array_get($urlParams, 'name') }}">
                    </p>
                    <p class="inputs">
                        <span class="special">电话：</span>
                        <input type="text" name="phone" value="{{ array_get($urlParams, 'phone') }}">
                    </p>
                    <p class="select" style="width: 300px;">
                        <span class="special">是否显示状态：</span>
                        <select name="is_show">
                            <option value="">全部</option>
                            <option value="1" @if(array_get($urlParams, 'is_show') == 1)selected="selected"@endif>是</option>
                            <option value="2" @if(array_get($urlParams, 'is_show') == 2)selected="selected"@endif>否</option>
                        </select>
                    </p>
                    <button class="sub">搜索</button>
                </form>
            </div>
        </div>
    </div>
    <div class="container-fluid main-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="widget-container fluid-height clearfix">
                    <div class="widget-content padded clearfix">
                        {!! $pageList !!}
                        <p>用户意见列表</p>
                        <table class="table table-bordered table-striped" id="dataTable1">
                            <thead>
                                <th width="5%">ID</th>
                                <th width="5%">用户ID</th>
                                <th width="7%">姓名</th>
                                <th width="7%">手机号</th>
                                <th width="20%">意见内容</th>
                                <th width="20%">答复内容</th>
                                <th width="5%">显示状态</th>
                                <th width="5%">答复状态</th>
                                <th width="10%"><font style="color: green;">提交时间</font><br><font style="color: red;">答复时间</font></th>
                                <th width="15%">操作</th>
                            </thead>
                            <tbody style="text-align: center;">
                            @foreach($list as $key => $value)
                                <tr>
                                    <td>
                                        {{ $value->id }}
                                    </td>
                                    <td>
                                        {{ $value->user_id }}
                                    </td>
                                    <td>
                                        {{ $value->name }}
                                    </td>
                                    <td>
                                        {{ $value->phone }}
                                    </td>
                                    <td style="text-align:left;word-break: break-all; word-wrap:break-word;">
                                        {{ $value->content }}
                                    </td>
                                    <td style="text-align:left;word-break: break-all; word-wrap:break-word;">
                                        {{ $value->reply_content }}
                                    </td>
                                    <td style="color:@if($value->is_show) green @else red @endif;">
                                        @if($value->is_show) 显示 @else 隐藏 @endif
                                    </td>
                                    <td style="color:@if($value->reply_at) green @else red @endif;">
                                        @if($value->reply_at)
                                            已答复<br>
                                            答复人：{{ $value->reply_owner }}
                                        @else
                                            未答复
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($value->created_at))
                                            <font style="color: green;">{{ $value->created_at }}</font><br>
                                        @endif
                                        @if(!empty($value->reply_at))
                                            <font style="color: red;">{{ $value->reply_at }}</font><br>
                                        @endif
                                    </td>
                                    <td>
                                        @if($value->operate_list['allow_operate_show'])
                                            <a href="javascript:;" style="display: block;" onclick="changeShow({{ $value->id }})">
                                                @if($value->is_show) 隐藏 @else 显示 @endif
                                            </a>
                                        @endif
                                        @if($value->operate_list['allow_operate_reply'])
                                            <a href="javascript:;" style="display: block;" onclick="changeReply({{ $value->id }})">答复</a>
                                        @endif
                                        @if($value->operate_list['allow_operate_modify_reply'])
                                            <a href="javascript:;" style="display: block;" onclick="changeReply({{ $value->id }})">修改答复</a>
                                        @endif
                                        @if($value->operate_list['allow_operate_remove'])
                                            <a href="javascript:;" style="display: block;" onclick="removeAdmonition({{ $value->id }})">作废</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $pageList !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="float-window">
        <div class="common-window">

        </div>
        <div class="window-box" style="height: 220px;">
            <p>意见答复</p>
            <input type="hidden" id="admonReplyId" value="0"/>
            <textarea id="reply_content" style="width: 260px; height: 120px;"></textarea><br/>
            <button id="reply_submit">答复</button>
        </div>
    </div>
    <script>
        $(".common-window").click(function(){
            $(".float-window").hide();
            $(".window-box").hide();
        });
    </script>
    @if($operateList['change_show'])
        <script>
            function changeShow(id) {
                if (confirm('确定提交？')) {
                    $.post(
                        '{{ $operateUrl['change_url'] }}',
                        {id: id},
                        function (result) {
                            result = JSON.parse(result)
                            if (result.code == 200) {
                                location.href = '{{ $redirectUrl }}';
                            } else {
                                alert(result.msg)
                            }
                        }
                    )
                }
            }
        </script>
    @endif
    @if($operateList['change_remove'])
        <script>
            function removeAdmonition(id) {
                if (confirm('确定作废？')) {
                    $.post(
                        '{{ $operateUrl['remove_url'] }}',
                        {id: id},
                        function (result) {
                            result = JSON.parse(result)
                            if (result.code == 200) {
                                location.href = '{{ $redirectUrl }}';
                            } else {
                                alert(result.msg)
                            }
                        }
                    )
                }
            }
        </script>
    @endif
    @if($operateList['change_reply'])
        <script>
            function changeReply(id) {
                $("#admonReplyId").val(id);
                $("#reply_content").val('');
                $(".float-window").show();
                $(".window-box").show();
                $.post(
                    '{{ $operateUrl['reply_url'] }}',
                    {id: id},
                    function (result) {
                        result = JSON.parse(result)
                        if (result.code == 200) {
                            $("#reply_content").val(result.data.content);
                        } else {
                            alert(result.msg)
                        }
                    }
                )
            }
            $("#reply_submit").click(function () {
                if (confirm('确定提交答复？')) {
                    var admonId = $("#admonReplyId").val();
                    var replyContent = $("#reply_content").val();
                    if (admonId == '0' || admonId == '') {
                        alert('缺少ID')
                        return false
                    }
                    if (replyContent == '') {
                        alert('缺少答复内容')
                        return false
                    }
                    $.post(
                        '{{ $operateUrl['reply_url'] }}',
                        {id: admonId, content: replyContent, submit: 1},
                        function (result) {
                            result = JSON.parse(result)
                            if (result.code == 200) {
                                location.href = '{{ $redirectUrl }}';
                            } else {
                                alert(result.msg)
                            }
                        }
                    )
                }
            })
        </script>
    @endif
@endsection
