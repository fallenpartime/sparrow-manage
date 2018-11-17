@extends('admin.layouts.main')
@section('title', '业务日志列表-日志管理-权限中心')
@section('body_content')
    <link href="/assets/stylesheets/common.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/assets/stylesheets/font-awesome.css" media="all" rel="stylesheet" type="text/css" />
    <script src="/assets/javascripts/WdatePicker.js" type="text/javascript"></script>
    @include('admin.menus.admin_log_menu', ['menu' => $menu, 'admin_info' => $admin_info, 'ts_list' => $ts_list])
    <div class="row" style="margin-bottom: 20px;margin-top: 20px;">
        <div class="col-lg-12">
            <div class="widget-container fluid-height clearfix search-window">
                <form action="">
                    <p class="inputs">
                        <span class="special">操作人：</span>
                        <select name="user_id" style="width: 150px;">
                            <option value="">全部</option>
                            @if(!empty($owners))
                                @foreach($owners as $owner)
                                    <option value="{{ $owner->id }}" @if(array_get($urlParams, 'user_id') == $owner->id)selected="selected"@endif>{{ $owner->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </p>
                    <p class="inputs">
                        <span class="special">操作对象ID：</span>
                        <input type="text" name="object_id" value="{{ array_get($urlParams, 'object_id') }}">
                    </p>
                    <p class="select" style="width: 300px;">
                        <span class="special">操作名称：</span>
                        <select name="operate_type">
                            <option value="">全部</option>
                            @if(!empty($typeList))
                                @foreach($typeList as $operateId => $operateValue)
                                    <option value="{{ $operateId }}" @if(array_get($urlParams, 'operate_type') == $operateId)selected="selected"@endif>{{ $operateValue }}</option>
                                @endforeach
                            @endif
                        </select>
                    </p>
                    <p class="about">
                        <span class="special">操作时间：</span>
                        <span>从</span>
                        <input name="from_time" type="text" class="Wdate"
                               onfocus="WdatePicker({isShowWeek:true,readOnly:'true',dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'2010-10-01 00:00:00',maxDate:'2099-12-31 59:59:59'})"
                               value="{{ array_get($urlParams, 'from_time') }}" style="width: 150px;"/>
                        <span>到</span>
                        <input name="end_time" type="text" class="Wdate"
                               onfocus="WdatePicker({isShowWeek:true,readOnly:'true',dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'2010-10-01 00:00:00',maxDate:'2099-12-31 59:59:59'})"
                               value="{{ array_get($urlParams, 'end_time') }}" style="width: 150px;"/>
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
                        <p>业务日志列表</p>
                        <table class="table table-bordered table-striped" id="dataTable1">
                            <thead>
                                <th width="10%">ID</th>
                                <th width="10%">用户名</th>
                                <th width="10%">操作名称</th>
                                <th width="10%">操作对象ID</th>
                                <th width="30%">操作备注</th>
                                <th width="15%">IP</th>
                                <th width="15%">创建时间</th>
                            </thead>
                            <tbody style="text-align: center;">
                            @foreach($list as $key => $value)
                                <tr>
                                    <td>
                                        {{ $value->id }}
                                    </td>
                                    <td>
                                        @if(!empty($value->user))
                                            ID：{{ $value->user_id }}<br>
                                            姓名：{{ $value->user->name }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($typeList[$value->operate_type]))
                                            {{ $typeList[$value->operate_type] }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $value->object_id }}
                                    </td>
                                    <td style="text-align:left;word-break: break-all; word-wrap:break-word;">
                                        {{ $value->memo }}
                                    </td>
                                    <td>
                                        {{ $value->ip }}
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
