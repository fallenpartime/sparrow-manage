<div class="row" style="margin-bottom: 20px;">
    <div class="col-lg-12">
        <div class="widget-container fluid-height clearfix">
            <div class="col-lg-11">
                <div class="heading">
                    <span style="font-size: 14px;color: #333;font-weight: 600;display: block;float: left;padding:4px 0;">角色管理</span>
                </div>
                <div class="widget-content padded">
                    <div class="row" style="font-size: 0;">
                        @if(!empty($admin_info['is_manager'] || in_array('roles', $ts_list)))
                            <a href="{{ route('roles') }}">
                                <dl class="btn btn-lg btn-primary-outline">
                                    <dt><img src="/assets/images/manage.png"></dt>
                                    <dd @if(in_array('roles', $menu)) style="color:#007aff;"@endif>角色列表</dd>
                                </dl>
                            </a>
                        @endif
                        @if(!empty($admin_info['is_manager'] || in_array('roleInfo', $ts_list)))
                            <a href="{{ route('roleInfo', ['work_no'=>1]) }}">
                                <dl class="btn btn-lg btn-primary-outline">
                                    <dt><img src="/assets/images/manage.png"></dt>
                                    <dd @if(in_array('roleInfo', $menu)) style="color:#007aff;"@endif>角色配置</dd>
                                </dl>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>