@extends('admin.layouts.main')
@section('title', '学区列表-学区管理-学校管理中心')
@section('body_content')
    <link href="/assets/stylesheets/common.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/assets/stylesheets/font-awesome.css" media="all" rel="stylesheet" type="text/css" />
    <script src="/assets/javascripts/WdatePicker.js" type="text/javascript"></script>
    @include('admin.menus.school.district_menu', ['menu' => $menu, 'admin_info' => $admin_info, 'ts_list' => $ts_list])
    <div class="row" style="margin-bottom: 20px;margin-top: 20px;">
        <div class="col-lg-12">
            <div class="widget-container fluid-height clearfix search-window">
                <form action="">
                    <p class="inputs">
                        <span class="special">学区编号：</span>
                        <input type="text" name="no" value="{{ array_get($urlParams, 'no') }}">
                    </p>
                    <p class="inputs">
                        <span class="special">学区名称：</span>
                        <input type="text" name="name" value="{{ array_get($urlParams, 'name') }}">
                    </p>
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
                        <p>学区列表</p>
                        <table class="table table-bordered table-striped" id="dataTable1">
                            <thead>
                                <th width="24%">学区编号</th>
                                <th width="24%">学区名</th>
                                <th width="24%">创建时间</th>
                                <th width="24%">操作</th>
                            </thead>
                            <tbody style="text-align: center;">
                            @foreach($list as $key => $value)
                                <tr>
                                    <td>
                                        {{ $value->no }}
                                    </td>
                                    <td style="color:@if($value->is_show) green @else red @endif;">
                                        {{ $value->name }}
                                    </td>
                                    <td>
                                        {{ $value->created_at }}
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
@endsection