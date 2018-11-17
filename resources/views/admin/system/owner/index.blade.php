@extends('admin.layouts.main')
@section('title', '用户列表-用户管理-权限中心')
@section('body_content')
    <link href="/assets/stylesheets/common.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/assets/stylesheets/font-awesome.css" media="all" rel="stylesheet" type="text/css" />
    @include('admin.menus.admin_user_menu', ['menu' => $menu, 'admin_info' => $admin_info, 'ts_list' => $ts_list])
    <div class="row" style="margin-bottom: 20px;margin-top: 20px;">
        <div class="col-lg-12">
            <div class="widget-container fluid-height clearfix search-window">
                <form action="">
                    <p class="inputs">
                        <span class="special">用户名：</span>
                        <input type="text" name="name" value="{{ array_get($urlParams, 'name') }}">
                    </p>
                    <p class="inputs">
                        <span class="special">电话：</span>
                        <input type="text" name="phone" value="{{ array_get($urlParams, 'phone') }}">
                    </p>
                    @if(false)
                    <p class="select" style="width: 300px;">
                        <span class="special">显示为执行人：</span>
                        <select name="is_owner">
                            <option value="">全部</option>
                            <option value="2" @if(array_get($urlParams, 'is_owner') == 2)selected="selected"@endif>是</option>
                            <option value="1" @if(array_get($urlParams, 'is_owner') == 1)selected="selected"@endif>否</option>
                        </select>
                    </p>
                    @endif
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
                        <p>用户列表</p>
                        <table class="table table-bordered table-striped" id="dataTable1">
                            <thead>
                            <th style="width: 10%;">
                                用户ID
                            </th>
                            <th style="width: 10%;">
                                用户名
                            </th>
                            <th style="width: 15%;">
                                角色
                            </th>
                            <th>
                                账号状况
                            </th>
                            <th style="width: 10%;">
                                操作
                            </th>
                            </thead>
                            <tbody style="text-align: center;">
                            @if(!empty($list))
                                @foreach($list as $key => $value)
                                    <tr>
                                        <td>{{ $value['user_id'] }}</td>
                                        <td style="color:@if($value['is_owner'] == 1) green @else grey @endif">
                                            {{ $value['name'] }}
                                        </td>
                                        <td>
                                            @if(!empty($value['role_no'])){{ $value['role_name'] }}-{{ $value['role_no'] }}@endif<br>
                                            入口地址：{{ $value['indexTag'] }}<br>
                                        </td>
                                        <td style="text-align:left;word-break: break-all; word-wrap:break-word;">
                                            创建时间:{{ $value['created_at'] }}<br>
                                            电话:{{ $value['phone'] }}<br>
                                            {!! $value['status_desc'] !!}
                                        </td>
                                        <td>
                                            <a href="{{ $value['edit_url'] }}" style="display: block;">编辑信息</a>
                                            <a href="{{ $value['auth_url'] }}" style="display: block;">编辑权限</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection