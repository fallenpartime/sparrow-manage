@extends('admin.layouts.main')
@section('title', '网络投票明细-网络投票活动-活动管理中心')
@section('body_content')
    <link href="/assets/stylesheets/common.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/assets/stylesheets/font-awesome.css" media="all" rel="stylesheet" type="text/css" />
    <script src="/assets/javascripts/WdatePicker.js" type="text/javascript"></script>
    @include('admin.menus.activity.poll_menu', ['menu' => $menu, 'admin_info' => $admin_info, 'ts_list' => $ts_list])
    <div class="row" style="margin-bottom: 20px;margin-top: 20px;">
        <div class="col-lg-12">
            <div class="widget-container fluid-height clearfix search-window">
                <form action="">
                    <p class="about">
                        <span class="special">创建时间：</span>
                        <span>从</span>
                        <input name="from_time" type="text" class="Wdate"
                               onfocus="WdatePicker({isShowWeek:true,readOnly:'true',dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'2010-10-01 00:00:00',maxDate:'2099-12-31 59:59:59'})"
                               value="{{ array_get($urlParams, 'from_time') }}" style="width: 150px;"/>
                        <span>到</span>
                        <input name="end_time" type="text" class="Wdate"
                               onfocus="WdatePicker({isShowWeek:true,readOnly:'true',dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'2010-10-01 00:00:00',maxDate:'2099-12-31 59:59:59'})"
                               value="{{ array_get($urlParams, 'end_time') }}" style="width: 150px;"/>
                    </p>
                    <p class="inputs">
                        <span class="special">用户ID：</span>
                        <input type="text" name="user_id" value="{{ array_get($urlParams, 'user_id') }}">
                    </p>
                    <p class="inputs">
                        <span class="special">活动ID：</span>
                        <input type="text" name="activity_id" value="{{ array_get($urlParams, 'activity_id') }}">
                    </p>
                    <p class="inputs">
                        <span class="special">问题ID：</span>
                        <input type="text" name="question_id" value="{{ array_get($urlParams, 'question_id') }}">
                    </p>
                    <p class="select" style="width: 300px;">
                        <span class="special">问题资源类型：</span>
                        <select name="type">
                            <option value="">全部</option>
                            <option value="1" @if(array_get($urlParams, 'type') == 1)selected="selected"@endif>文本</option>
                            <option value="2" @if(array_get($urlParams, 'type') == 2)selected="selected"@endif>图片</option>
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
                        <p></p>
                        <table class="table table-bordered table-striped" id="dataTable1">
                            <thead>
                                <th width="5%">ID</th>
                                <th width="13%">活动信息</th>
                                <th width="13%">用户信息</th>
                                <th width="10%">用户头像</th>
                                <th width="13%">问题信息</th>
                                <th width="13%">选项信息</th>
                                <th width="13%">选项自填信息</th>
                                <th width="7%">创建时间</th>
                            </thead>
                            <tbody style="text-align: center;">
                            @foreach($list as $key => $value)
                                <tr>
                                    <td>
                                        {{ $value->id }}
                                    </td>
                                    <td style="text-align:left;word-break: break-all; word-wrap:break-word;">
                                        @if(!empty($value->activity))
                                            ID:{{ $value->activity_id }}<br>
                                            标题:{{ $value->activity->title }}
                                        @endif
                                    </td>
                                    <td style="text-align:left;word-break: break-all; word-wrap:break-word;">
                                        @if(!empty($value->user))
                                            ID:{{ $value->user_id }}<br>
                                            昵称:{{ $value->user->nick_name }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($value->user) && !empty($value->user->face))
                                            <a href="{{ $value->user->face }}" target="_blank"><img src="{{ $value->user->face }}" style="width: 100px; height: 100px;"/></a>
                                        @endif
                                    </td>
                                    <td style="text-align:left;word-break: break-all; word-wrap:break-word;">
                                        @if(!empty($value->question))
                                            ID:{{ $value->question_id }}<br>
                                            @if($value->question->type)
                                                题目类型:图片<br>
                                                题目图片:
                                                @if(!empty($value->question->source))
                                                    <a href="{{ $value->question->source }}" target="_blank"><img src="{{ $value->question->source }}" style="width: 100px; height: 100px;"/></a>
                                                @endif
                                            @else
                                                题目类型:文字<br>
                                                题目标题:{{ $value->question->title }}
                                            @endif
                                        @endif
                                    </td>
                                    <td style="text-align:left;word-break: break-all; word-wrap:break-word;">
                                        @if(!empty($value->answer))
                                            ID:{{ $value->answer_id }}<br>
                                            题目标题:{{ $value->answer->title }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $value->other }}
                                    </td>
                                    <td>
                                        {{ $value->created_at }}
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
@endsection
