<div class="row" style="margin-bottom: 20px;">
    <div class="col-lg-12">
        <div class="widget-container fluid-height clearfix">
            <div class="col-lg-11">
                <div class="heading">
                    <span style="font-size: 14px;color: #333;font-weight: 600;display: block;float: left;padding:4px 0;">网络投票管理</span>
                </div>
                <div class="widget-content padded">
                    <div class="row" style="font-size: 0;">
                        @if(!empty($admin_info['is_manager'] || in_array('polls', $ts_list)))
                            <a href="{{ route('polls') }}">
                                <dl class="btn btn-lg btn-primary-outline">
                                    <dt><img src="/assets/images/manage.png"></dt>
                                    <dd @if(in_array('polls', $menu)) style="color:#007aff;"@endif>投票列表</dd>
                                </dl>
                            </a>
                        @endif
                        @if(!empty($admin_info['is_manager'] || in_array('activityPollInfo', $ts_list)))
                            <a href="{{ route('activityPollInfo', ['work_no'=>1]) }}">
                                <dl class="btn btn-lg btn-primary-outline">
                                    <dt><img src="/assets/images/manage.png"></dt>
                                    <dd @if(in_array('activityPollInfo', $menu)) style="color:#007aff;"@endif>投票配置</dd>
                                </dl>
                            </a>
                        @endif
                        @if(!empty($admin_info['is_manager'] || in_array('activityPollQuestions', $ts_list)))
                            <a href="{{ route('activityPollQuestions') }}">
                                <dl class="btn btn-lg btn-primary-outline">
                                    <dt><img src="/assets/images/manage.png"></dt>
                                    <dd @if(in_array('activityPollQuestions', $menu)) style="color:#007aff;"@endif>问题列表</dd>
                                </dl>
                            </a>
                        @endif
                        @if(!empty($admin_info['is_manager'] || in_array('activityPollQuestionInfo', $ts_list)))
                            <a href="{{ route('activityPollQuestionInfo', ['work_no'=>1]) }}">
                                <dl class="btn btn-lg btn-primary-outline">
                                    <dt><img src="/assets/images/manage.png"></dt>
                                    <dd @if(in_array('activityPollQuestionInfo', $menu)) style="color:#007aff;"@endif>问题配置</dd>
                                </dl>
                            </a>
                        @endif
                        @if(!empty($admin_info['is_manager'] || in_array('activityPollVoteData', $ts_list)))
                            <a href="{{ route('activityPollVoteData') }}">
                                <dl class="btn btn-lg btn-primary-outline">
                                    <dt><img src="/assets/images/manage.png"></dt>
                                    <dd @if(in_array('activityPollVoteData', $menu)) style="color:#007aff;"@endif>活动投票数据</dd>
                                </dl>
                            </a>
                        @endif
                        @if(!empty($admin_info['is_manager'] || in_array('activityPollVotes', $ts_list)))
                            <a href="{{ route('activityPollVotes') }}">
                                <dl class="btn btn-lg btn-primary-outline">
                                    <dt><img src="/assets/images/manage.png"></dt>
                                    <dd @if(in_array('activityPollVotes', $menu)) style="color:#007aff;"@endif>活动投票明细</dd>
                                </dl>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
