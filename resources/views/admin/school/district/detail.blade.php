@extends('admin.layouts.main')
@section('title', '学区配置-学区管理-学校管理中心')
@section('body_content')
    <link href="/assets/stylesheets/common.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/assets/stylesheets/font-awesome.css" media="all" rel="stylesheet" type="text/css" />
    @include('admin.menus.school.district_menu', ['menu' => $menu, 'admin_info' => $admin_info, 'ts_list' => $ts_list])
    <div class="container-fluid main-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="widget-container fluid-height clearfix">
                    <div class="col-sm-6 col-md-6 col-lg-6 downline-box">
                        <form id="userForm" action="" method="post" onsubmit="return false">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ !empty($record)? $record->id: 0 }}">
                            <div class="bank-infos" style="min-height: 300px; height: auto;">
                                <div class="p-boxs" style="padding-top: 10px;">
                                    <p style="width:1.5em;">学区设置</p>
                                </div>
                                <div class="bank-form">
                                    <span class="blank">学区名：</span><input type="text" name="name" id="name"  style="width: 50%;" value="{{ !empty($record)? $record->name: '' }}"/><span class="icon">*</span><br/>
                                    <span class="blank">编号：</span><input type="text" name="no" id="no" style="width:50%;" value="{{ !empty($record)? $record->no: '' }}"/><span class="icon">*</span><br/>
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