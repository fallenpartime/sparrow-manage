@extends('admin.layouts.main')
@section('title', '分组详情-分组管理-权限中心')
@section('body_content')
    <link href="/assets/stylesheets/common.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/assets/stylesheets/font-awesome.css" media="all" rel="stylesheet" type="text/css" />
    @include('admin.menus.admin_group_menu', ['menu' => $menu, 'admin_info' => $admin_info, 'ts_list' => $ts_list])
    <form id="groupForm" action="#" method="post" onsubmit="return false">
        {{ csrf_field() }}
        <!-- 详情 -->
        <input type="hidden" name="id" value="{{ !empty($record)? $record->id: 0 }}">
        <div class="container-fluid main-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="widget-container fluid-height clearfix">
                        <div class="widget-content padded clearfix">
                            <p>分组设置</p>
                            <table class="table table-bordered table-striped table-hover" id="">
                                <thead>
                                <th width="30%">标题</th>
                                <th width="65%">内容</th>
                                </thead>
                                <tbody style="text-align: center;">
                                <tr>
                                    <td>分组&nbsp;&nbsp;&nbsp;ID</td>
                                    <td style="text-align: left">
                                        <input type="text" name="group_no" id="group_no"  style="width: 50%;" value="{{ !empty($record)? $record->group_no: '' }}" style="width: 50%;"/><span class="icon">*</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>分组名称</td>
                                    <td style="text-align: left">
                                        <input type="text" name="name" id="name"  style="width: 50%;" value="{{ !empty($record)? $record->name: '' }}" style="width: 50%;"/><span class="icon">*</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>分组Tip</td>
                                    <td style="text-align: left">
                                        <input type="text" name="tip" id="tip" style="width: 50%;" value="{{ !empty($record)? $record->tip: '' }}" style="width: 50%;"/><span class="icon">*</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
{{--            @include('admin.system.authority.checked_list')--}}
        </div>
        <!-- 提交 -->
        <div class="container-fluid main-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="widget-container fluid-height clearfix">
                        <div class="widget-content padded clearfix">
                            <table class="table table-bordered table-striped table-hover" id="">
                                <tr>
                                    <td colspan="3">
                                        <input type="submit" value="保存" onclick="groupSave();" style="margin-left: 20px;margin-right: 20px;"/>
                                        <a href="javascript:;" onclick="location.href=document.referrer;" style="margin-left: 20px;margin-right: 20px;">返回</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        function groupSave() {
            if (confirm('确定提交？')) {
                $.post(
                    '{{ $actionUrl }}',
                    $('#groupForm').serialize(),
                    function (result) {
                        result = JSON.parse(result)
                        if (result.code == 200) {
                            var redirectUrl = '{{ $redirectUrl }}';
                            location.href=redirectUrl;
                        } else {
                            alert(result.msg)
                        }
                    }
                )
            }
        }
    </script>
    <script>
        $(".first_all_check").click(function () {
            var checkedValue = $(this).prop('checked')
            if (checkedValue) {
                $(".first_level").prop('checked', true)
            } else {
                $(".first_level").attr('checked', false)
            }
        })
        $(".second_all_check").click(function () {
            var checkedValue = $(this).prop('checked')
            if (checkedValue) {
                $(".second_level").prop('checked', true)
            } else {
                $(".second_level").attr('checked', false)
            }
        })
        $(".third_all_check").click(function () {
            var checkedValue = $(this).prop('checked')
            if (checkedValue) {
                $(".third_level").prop('checked', true)
            } else {
                $(".third_level").attr('checked', false)
            }
        })
    </script>
@endsection