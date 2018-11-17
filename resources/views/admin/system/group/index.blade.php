@extends('admin.layouts.main')
@section('title', '分组列表-分组管理-权限中心')
@section('body_content')
    <link href="/assets/stylesheets/common.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/assets/stylesheets/font-awesome.css" media="all" rel="stylesheet" type="text/css" />
    @include('admin.menus.admin_group_menu', ['menu' => $menu, 'admin_info' => $admin_info, 'ts_list' => $ts_list])
    <div class="container-fluid main-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="widget-container fluid-height clearfix">
                    <div class="widget-content padded clearfix">
                        <p>分组列表</p>
                        <table class="table table-bordered table-striped" id="dataTable1">
                            <thead>
                            <th width="19%">分组ID</th>
                            <th width="19%">分组名</th>
                            <th width="19%">分组Tip</th>
                            <th width="19%">创建时间</th>
                            <th width="19%">操作</th>
                            </thead>
                            <tbody style="text-align: center;">
                            @if(!empty($list))
                                @foreach($list as $key => $value)
                                <tr>
                                    <td>
                                        {{ $value->group_no }}
                                    </td>
                                    <td>
                                        {{ $value->name }}
                                    </td>
                                    <td>
                                        {{ $value->tip }}
                                    </td>
                                    <td>
                                        {{ $value->created_at }}
                                    </td>
                                    <td>
                                        <a href="{{ route('groupInfo', ['work_no' => 1, 'id' => $value->id]) }}" style="display: block;">编辑</a>
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