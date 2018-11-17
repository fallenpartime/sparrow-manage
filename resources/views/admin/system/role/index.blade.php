@extends('admin.layouts.main')
@section('title', '角色列表-角色管理-权限中心')
@section('body_content')
    <link href="/assets/stylesheets/common.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/assets/stylesheets/font-awesome.css" media="all" rel="stylesheet" type="text/css" />
    @include('admin.menus.admin_role_menu', ['menu' => $menu, 'admin_info' => $admin_info, 'ts_list' => $ts_list])
    <div class="container-fluid main-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="widget-container fluid-height clearfix">
                    <div class="widget-content padded clearfix">
                        <p>角色列表</p>
                        <table class="table table-bordered table-striped" id="dataTable1">
                            <thead>
                                <th width="10%">角色ID</th>
                                <th width="10%">角色名</th>
                                <th width="30%">权限列表</th>
                                <th width="15%">分组情况</th>
                                {{--<th width="15%">分组权限</th>--}}
                                <th width="15%">创建时间</th>
                                <th>操作</th>
                            </thead>
                            <tbody style="text-align: center;">
                            @if(!empty($list))
                                @foreach($list as $key => $value)
                                    <tr>
                                        <td>
                                            {{ $value['no'] }}
                                        </td>
                                        <td>
                                            {{ $value['name'] }}<br>
                                            入口：{{ $value['indexTag'] }}
                                        </td>
                                        <td style="word-break:break-all; text-align: left;">
                                            {{ $value['actions'] }}
                                        </td>
                                        <td>
                                            {!! $value['group_desc'] !!}
                                        </td>
                                        {{--<td style="text-align:left;word-break: break-all; word-wrap:break-word;">--}}
                                            {{--@json($value['group_ext'])--}}
                                        {{--</td>--}}
                                        <td>
                                            {{ $value['created_at'] }}
                                        </td>
                                        <td>
                                            <a href="{{ $value['edit_url'] }}" style="display: block;">编辑</a>
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