@extends('admin.layouts.main')
@section('title', '权限详情-权限管理-权限中心')
@section('body_content')
    <link href="/assets/stylesheets/common.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/assets/stylesheets/font-awesome.css" media="all" rel="stylesheet" type="text/css" />
    @include('admin.menus.admin_authority_menu', ['menu' => $menu, 'admin_info' => $admin_info, 'ts_list' => $ts_list])
    <div class="container-fluid main-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="widget-container fluid-height clearfix">
                    <div class="col-sm-6 col-md-6 col-lg-6 downline-box">
                        <form id="authorForm" action="#" method="post" onsubmit="return false">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ !empty($record)? $record->id: 0 }}">
                            <div class="bank-infos">
                                <div class="p-boxs">
                                    <p style="width:1.5em;">权限设置</p>
                                </div>
                                <div class="bank-form">
                                    <span class="blank">所属一级权限：</span>
                                    <select name="first_menu" id="first_menu" style="width: 50%;">
                                        <option value=""></option>
                                    </select><br/>
                                    <span class="blank">所属二级权限：</span>
                                    <select name="second_menu" id="second_menu" style="width: 50%;">
                                        <option value=""></option>
                                    </select><br/>
                                    <span class="blank">权限名称：</span><input type="text" name="ts_name" id="tsname"  style="width: 50%;" value="{{ !empty($record)? $record->name: '' }}"/><span class="icon">*</span><br/>
                                    <span class="blank">权限标示：</span><input type="text" name="ts_action" id="tsaction" style="width:50%;" value="{{ !empty($record)? $record->ts_action: '' }}"/><span class="icon">*</span><br/>
                                    <span class="blank">权限类型：</span>
                                    <select id="type" name="type" style="width: 50%;">
                                        <option value="0">请选择</option>
                                        <option value="1" @if(!empty($record) && $record->type==1)selected="selected"@endif>一级权限</option>
                                        <option value="2" @if(!empty($record) && $record->type==2)selected="selected"@endif>二级权限</option>
                                        <option value="3" @if(!empty($record) && $record->type==3)selected="selected"@endif>三级权限</option>
                                    </select><span class="icon">*</span>
                                </div>
                            </div>
                            <div class="downline-sub">
                                <input type="submit" value="保存" onclick="authorizationSave();"/>
                                <a href="javascript:;" onclick="location.href=document.referrer;">返回</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var auth_arr = @json($relate_menu);
        function initFirstMenu() {
            var pDom = $('#first_menu');
            pDom.empty();
            pDom.append('<option value=""></option>');
            for(var i in auth_arr){
                pDom.append('<option value="'+auth_arr[i]['menu'].id+'">'+auth_arr[i]['menu'].name+'</option>');
            }
        }
        $('#first_menu').change(function () {
            var pDom = $('#second_menu');
            var parent = $('#first_menu').val();
            pDom.empty();
            if (parent != '') {
                pDom.append('<option value=""></option>');
                for(var j in auth_arr[parent]['list']){
                    pDom.append('<option value="'+auth_arr[parent]['list'][j]['menu'].id+'">'+auth_arr[parent]['list'][j]['menu'].name+'</option>');
                }
            }
        })
        initFirstMenu();
        <?php if(!empty($first_menu)): ?>
        $('#first_menu').val('<?= $first_menu ?>');
        $('#first_menu').trigger('change');
        <?php endif; ?>
        <?php if(!empty($second_menu)): ?>
        $('#second_menu').val('<?= $second_menu ?>');
        $('#second_menu').trigger('change');
        <?php endif; ?>
        function authorizationSave() {
            if (confirm('确定提交？')) {
                $.post(
                    '<?= $actionUrl ?>',
                    $('#authorForm').serialize(),
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
@endsection