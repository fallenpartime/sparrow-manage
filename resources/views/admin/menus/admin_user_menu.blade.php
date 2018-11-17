<div class="row" style="margin-bottom: 20px;">
    <div class="col-lg-12">
        <div class="widget-container fluid-height clearfix">
            <div class="col-lg-11">
                <div class="heading">
                    <span style="font-size: 14px;color: #333;font-weight: 600;display: block;float: left;padding:4px 0;">用户管理</span>
                </div>
                <div class="widget-content padded">
                    <div class="row" style="font-size: 0;">
                        @if(!empty($admin_info['is_manager'] || in_array('owners', $ts_list)))
                            <a href="{{ route('owners') }}">
                                <dl class="btn btn-lg btn-primary-outline">
                                    <dt><img src="/assets/images/manage.png"></dt>
                                    <dd @if(in_array('owners', $menu)) style="color:#007aff;"@endif>用户列表</dd>
                                </dl>
                            </a>
                        @endif
                        @if(!empty($admin_info['is_manager'] || in_array('ownerInfo', $ts_list)))
                            <a href="{{ route('ownerInfo', ['work_no'=>1]) }}">
                                <dl class="btn btn-lg btn-primary-outline">
                                    <dt><img src="/assets/images/manage.png"></dt>
                                    <dd @if(in_array('ownerInfo', $menu)) style="color:#007aff;"@endif>用户配置</dd>
                                </dl>
                            </a>
                        @endif
                        @if(false)
                        @if(!empty($admin_info['is_manager'] || in_array('ownerAuthority', $ts_list)))
                            <a href="javascript:;">
                                <dl class="btn btn-lg btn-primary-outline">
                                    <dt><img src="/assets/images/manage.png"></dt>
                                    <dd @if(in_array('ownerAuthority', $menu)) style="color:#007aff;"@endif>用户权限</dd>
                                </dl>
                            </a>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
