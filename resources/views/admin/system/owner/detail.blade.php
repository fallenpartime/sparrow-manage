@extends('admin.layouts.main')
@section('title', '用户详情-用户管理-权限中心')
@section('body_content')
    <link href="/assets/stylesheets/common.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/assets/stylesheets/font-awesome.css" media="all" rel="stylesheet" type="text/css" />
    @include('admin.menus.admin_user_menu', ['menu' => $menu, 'admin_info' => $admin_info, 'ts_list' => $ts_list])
    <div class="container-fluid main-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="widget-container fluid-height clearfix">
                    <div class="col-sm-6 col-md-6 col-lg-6 downline-box">
                        <form id="userForm" action="" method="post" onsubmit="return false">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ !empty($record)? $record->id: 0 }}">
                            <div class="bank-infos" style="min-height: 350px; height: auto;">
                                <div class="p-boxs" style="padding-top: 30px;">
                                    <p style="width:1.5em;">用户设置</p>
                                </div>
                                <div class="bank-form">
                                    <span class="blank">用户名：</span><input type="text" name="name" id="name"  style="width: 50%;" value="{{ !empty($user)? $user->name: '' }}"/><span class="icon">*</span><br/>
                                    <span class="blank">密码：</span><input type="text" name="pwd" style="width:50%;" value=""/>@if(!empty($record))<input type="checkbox" name="change_pwd" value="1"/>修改密码@endif<br/>
                                    <span class="blank">电话：</span><input type="text" name="phone" id="phone" style="width:50%;" value="{{ !empty($user)? $user->phone: '' }}"/><span class="icon">*</span><br/>
                                    <span class="blank">角色：</span>
                                    <select name="role_id" id="roleid" style="width: 50%;">
                                        <option value="0">请选择</option>
                                        @if(!empty($roles))
                                            @foreach($roles as $role)
                                                <option value="{{ $role->role_no }}" @if(!empty($record) && $record->role_id == $role->role_no)selected="selected"@endif>{{ $role->name }}</option>
                                            @endforeach
                                        @endif
                                    </select><br/>
                                    @if(false)
                                    <span class="blank">显示为执行人：</span>
                                    <select name="is_owner" style="width: 50%;">
                                        <option value="0">否</option>
                                        <option value="1" @if(!empty($record) && $record->is_owner == 1)selected="selected"@endif>是</option>
                                    </select><br/>
                                    @endif
                                    <span class="blank">是否激活：</span>
                                    <select name="is_admin" style="width: 50%;">
                                        <option value="0">否</option>
                                        <option value="1" @if(!empty($record) && $record->is_admin == 1)selected="selected"@endif>是</option>
                                    </select><br/>
                                    @if($admin_info['is_super'])
                                    <span class="blank">是否超级管理员：</span>
                                    <select name="is_super" style="width: 50%;">
                                        <option value="0">否</option>
                                        <option value="1" @if(!empty($record) && $record->is_super == 1)selected="selected"@endif>是</option>
                                    </select><br/>
                                    @endif
                                </div>
                            </div>
                            <div class="downline-sub">
                                <input type="submit" value="保存" onclick="userSave();"/>
                                <a href="javascript:;" onclick="location.href=document.referrer;">返回</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function userSave() {
            if (confirm('确定提交？')) {
                $.post(
                    '{{ $actionUrl }}',
                    $('#userForm').serialize(),
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
@endsection