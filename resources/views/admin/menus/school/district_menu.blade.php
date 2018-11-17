<div class="row" style="margin-bottom: 20px;">
    <div class="col-lg-12">
        <div class="widget-container fluid-height clearfix">
            <div class="col-lg-11">
                <div class="heading">
                    <span style="font-size: 14px;color: #333;font-weight: 600;display: block;float: left;padding:4px 0;">学区管理</span>
                </div>
                <div class="widget-content padded">
                    <div class="row" style="font-size: 0;">
                        @if(!empty($admin_info['is_manager'] || in_array('districts', $ts_list)))
                            <a href="{{ route('districts') }}">
                                <dl class="btn btn-lg btn-primary-outline">
                                    <dt><img src="/assets/images/manage.png"></dt>
                                    <dd @if(in_array('districts', $menu)) style="color:#007aff;"@endif>学区列表</dd>
                                </dl>
                            </a>
                        @endif
                        @if(!empty($admin_info['is_manager'] || in_array('districtInfo', $ts_list)))
                            <a href="{{ route('districtInfo', ['work_no'=>1]) }}">
                                <dl class="btn btn-lg btn-primary-outline">
                                    <dt><img src="/assets/images/manage.png"></dt>
                                    <dd @if(in_array('districtInfo', $menu)) style="color:#007aff;"@endif>学区配置</dd>
                                </dl>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>