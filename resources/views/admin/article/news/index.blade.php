@extends('admin.layouts.main')
@section('title', '教育资讯列表-教育新闻-文章管理中心')
@section('body_content')
    <link href="/assets/stylesheets/common.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/assets/stylesheets/font-awesome.css" media="all" rel="stylesheet" type="text/css" />
    <script src="/assets/javascripts/WdatePicker.js" type="text/javascript"></script>
    @include('admin.menus.article.news_menu', ['menu' => $menu, 'admin_info' => $admin_info, 'ts_list' => $ts_list])
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
                    <p class="about">
                        <span class="special">发布时间：</span>
                        <span>从</span>
                        <input name="from_publish_time" type="text" class="Wdate"
                               onfocus="WdatePicker({isShowWeek:true,readOnly:'true',dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'2010-10-01 00:00:00',maxDate:'2099-12-31 59:59:59'})"
                               value="{{ array_get($urlParams, 'from_publish_time') }}" style="width: 150px;"/>
                        <span>到</span>
                        <input name="end_publish_time" type="text" class="Wdate"
                               onfocus="WdatePicker({isShowWeek:true,readOnly:'true',dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'2010-10-01 00:00:00',maxDate:'2099-12-31 59:59:59'})"
                               value="{{ array_get($urlParams, 'end_publish_time') }}" style="width: 150px;"/>
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
                        <p>教育资讯列表</p>
                        <table class="table table-bordered table-striped" id="dataTable1">
                            <thead>
                                <th width="10%">ID</th>
                                <th width="15%">标题<br>作者</th>
                                <th width="10%">显示状态</th>
                                <th width="5%">阅读数</th>
                                <th width="5%">点赞数</th>
                                <th width="15%">创建时间</th>
                                <th width="15%">发布时间</th>
                                <th width="10%">列表头图</th>
                                <th width="15%">操作</th>
                            </thead>
                            <tbody style="text-align: center;">
                            @foreach($list as $key => $value)
                                <tr>
                                    <td>
                                        {{ $value->id }}
                                    </td>
                                    <td style="text-align:left;word-break: break-all; word-wrap:break-word;">
                                        <a href="{{ $value->show_url }}" target="_blank">{{ $value->title }}</a><br>
                                        @if(!empty($value->author))作者：{{ $value->author }}@endif
                                    </td>
                                    <td style="color:@if($value->is_show) green @else red @endif;">
                                        @if($value->is_show) 显示 @else 隐藏 @endif
                                    </td>
                                    <td>
                                        {{ $value->read_count }}
                                    </td>
                                    <td>
                                        {{ $value->like_count }}
                                    </td>
                                    <td>
                                        {{ $value->created_at }}
                                    </td>
                                    <td>
                                        {{ $value->published_at }}
                                    </td>
                                    <td>
                                        @if(!empty($value->list_pic))
                                            <a href="{{ $value->list_pic }}" target="_blank"><img src="{{ $value->list_pic }}" style="width: 100px; height: 100px;"/></a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($value->operate_list['allow_operate_edit'])
                                            <a href="{{ $value->edit_url }}" style="display: block;">编辑</a>
                                        @endif
                                        @if($value->operate_list['allow_operate_change'])
                                            <a href="javascript:;" style="display: block;" onclick="changeShow({{ $value->id }})">
                                                @if($value->is_show) 隐藏 @else 显示 @endif
                                            </a>
                                        @endif
                                        @if($value->operate_list['allow_operate_fresh'])
                                            <a href="javascript:;" style="display: block;" onclick="fresh({{ $value->id }})">刷新页面缓存</a>
                                        @endif
                                        @if($value->operate_list['allow_operate_remove'])
                                            <a href="javascript:;" style="display: block;" onclick="remove({{ $value->id }})">作废</a>
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
            function remove(id) {
                if (confirm('确定提交？')) {
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
    @if($operateList['change_fresh'])
        <script>
            function fresh(id) {
                if (confirm('确定活动刷新缓存？')) {
                    $.post(
                        '{{ $operateUrl['fresh_url'] }}',
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
@endsection
