<div class="row">
    <div class="col-lg-12" style="float:left;">
        <div class="widget-container fluid-height clearfix">
            <div class="widget-content padded clearfix">
                <p>角色权限</p>
                <table class="table table-bordered table-striped table-hover" id="">
                    <thead>
                        <th width="33%">一级权限&nbsp;&nbsp;<input type="checkbox" class="first_all_check" /></th>
                        <th width="33%">二级权限&nbsp;&nbsp;<input type="checkbox" class="second_all_check" /></th>
                        <th width="33%">三级权限&nbsp;&nbsp;<input type="checkbox" class="third_all_check" /></th>
                    </thead>
                    <tbody style="text-align: center;">
                    @if(!empty($authorities))
                        @foreach($authorities as $topItem)
                            <?php
                            $topModel = $topItem['menu'];
                            $secondLength = $topItem['length'];
                            $secondList = $topItem['list'];
                            $countSecond = 0;
                            ?>
                            @if(!empty($secondList))
                                @foreach($secondList as $secondItem)
                                    <?php
                                    $secondModel = $secondItem['menu'];
                                    $operateLength = $secondItem['length'];
                                    $operateList = $secondItem['list'];
                                    $operateSecond = 0;
                                    ?>
                                    @if(!empty($operateList))
                                        @foreach($operateList as $operateItem)
                                            <?php $operateModel = $operateItem['menu']; ?>
                                            <tr>
                                                @if($countSecond == 0 && $operateSecond == 0)
                                                    <td rowspan="{{ $secondLength }}"><input type="checkbox" class="first_level" name="auth_checked[]" value="{{ $topModel->ts_action }}" @if($topModel->is_checked)checked="checked"@endif/>&nbsp;&nbsp;{{ $topModel->name }}({{ $topModel->ts_action }})</td>
                                                @endif
                                                @if($operateSecond == 0)
                                                    <td rowspan="{{ $operateLength }}"><input type="checkbox" class="second_level" name="auth_checked[]" value="{{ $secondModel->ts_action }}" @if($secondModel->is_checked)checked="checked"@endif/>&nbsp;&nbsp;{{ $secondModel->name }}({{ $secondModel->ts_action }})</td>
                                                @endif
                                                <td><input type="checkbox" class="third_level" name="auth_checked[]" value="{{ $operateModel->ts_action }}" @if($operateModel->is_checked)checked="checked"@endif/>&nbsp;&nbsp;{{ $operateModel->name }}({{ $operateModel->ts_action }})</td>
                                                <?php $operateSecond++; ?>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            @if($countSecond == 0 && $operateSecond == 0)
                                                <td rowspan="{{ $secondLength }}"><input type="checkbox" class="first_level" name="auth_checked[]" value="{{ $topModel->ts_action }}" @if($topModel->is_checked)checked="checked"@endif/>&nbsp;&nbsp;{{ $topModel->name }}({{ $topModel->ts_action }})</td>
                                            @endif
                                            <td rowspan="{{ $operateLength }}"><input type="checkbox" class="second_level" name="auth_checked[]" value="{{ $secondModel->ts_action }}" @if($secondModel->is_checked)checked="checked"@endif/>&nbsp;&nbsp;{{ $secondModel->name }}({{ $secondModel->ts_action }})</td>
                                            <td></td>
                                        </tr>
                                    @endif
                                    <?php $countSecond++; ?>
                                @endforeach
                            @else
                                <tr>
                                    <td><input type="checkbox" class="first_level" name="auth_checked[]" value="{{ $topModel->ts_action }}" @if($topModel->is_checked)checked="checked"@endif/>&nbsp;&nbsp;{{ $topModel->name }}({{ $topModel->ts_action }})</td>
                                    <td rowspan="1"></td>
                                    <td rowspan="1"></td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if(false)
    <div class="col-lg-6" style="float:left;">
        <div class="widget-container fluid-height clearfix">
            <div class="widget-content padded clearfix">
                <p>分组权限</p>
                <table class="table table-bordered table-striped table-hover" id="">
                    <thead>
                    <th width="33%">一级权限</th>
                    <th width="33%">二级权限</th>
                    <th width="33%">三级权限</th>
                    </thead>
                    <tbody style="text-align: center;">
                    @if(!empty($groupAuthorities))
                        @foreach($groupAuthorities as $topItem)
                            <?php
                            $topModel = $topItem['menu'];
                            $secondLength = $topItem['length'];
                            $secondList = $topItem['list'];
                            $countSecond = 0;
                            ?>
                            @if(!empty($secondList))
                                @foreach($secondList as $secondItem)
                                    <?php
                                    $secondModel = $secondItem['menu'];
                                    $operateLength = $secondItem['length'];
                                    $operateList = $secondItem['list'];
                                    $operateSecond = 0;
                                    ?>
                                    @if(!empty($operateList))
                                        @foreach($operateList as $operateItem)
                                            <?php $operateModel = $operateItem['menu']; ?>
                                            <tr>
                                                @if($countSecond == 0 && $operateSecond == 0)
                                                    <td rowspan="{{ $secondLength }}"><input type="checkbox" class="group-auth" name="group_checked[]" disabled="disabled" value="{{ $topModel->ts_action }}" @if($topModel->is_checked)checked="checked"@endif/>&nbsp;&nbsp;{{ $topModel->name }}({{ $topModel->ts_action }})</td>
                                                @endif
                                                @if($operateSecond == 0)
                                                    <td rowspan="{{ $operateLength }}"><input type="checkbox" class="group-auth" name="group_checked[]" disabled="disabled" value="{{ $secondModel->ts_action }}" @if($secondModel->is_checked)checked="checked"@endif/>&nbsp;&nbsp;{{ $secondModel->name }}({{ $secondModel->ts_action }})</td>
                                                @endif
                                                <td><input type="checkbox" class="group-auth" name="group_checked[]" disabled="disabled" value="{{ $operateModel->ts_action }}" @if($operateModel->is_checked)checked="checked"@endif/>&nbsp;&nbsp;{{ $operateModel->name }}({{ $operateModel->ts_action }})</td>
                                                <?php $operateSecond++; ?>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            @if($countSecond == 0 && $operateSecond == 0)
                                                <td rowspan="{{ $secondLength }}"><input type="checkbox" class="group-auth" name="group_checked[]" disabled="disabled" value="{{ $topModel->ts_action }}" @if($topModel->is_checked)checked="checked"@endif/>&nbsp;&nbsp;{{ $topModel->name }}({{ $topModel->ts_action }})</td>
                                            @endif
                                            <td rowspan="{{ $operateLength }}"><input type="checkbox" class="group-auth" name="group_checked[]" disabled="disabled" value="{{ $secondModel->ts_action }}" @if($secondModel->is_checked)checked="checked"@endif/>&nbsp;&nbsp;{{ $secondModel->name }}({{ $secondModel->ts_action }})</td>
                                            <td></td>
                                        </tr>
                                    @endif
                                    <?php $countSecond++; ?>
                                @endforeach
                            @else
                                <tr>
                                    <td><input type="checkbox" class="group-auth" name="group_checked[]" disabled="disabled" value="{{ $topModel->ts_action }}" @if($topModel->is_checked)checked="checked"@endif/>&nbsp;&nbsp;{{ $topModel->name }}({{ $topModel->ts_action }})</td>
                                    <td rowspan="1"></td>
                                    <td rowspan="1"></td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>