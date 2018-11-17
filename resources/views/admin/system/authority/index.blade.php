@extends('admin.layouts.main')
@section('title', '权限列表-权限管理-权限中心')
@section('body_content')
    <link href="/assets/stylesheets/common.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/assets/stylesheets/font-awesome.css" media="all" rel="stylesheet" type="text/css" />
    @include('admin.menus.admin_authority_menu', ['menu' => $menu, 'admin_info' => $admin_info, 'ts_list' => $ts_list])
    <div class="container-fluid main-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="widget-container fluid-height clearfix">
                    <div class="widget-content padded clearfix">
                        <p>权限列表</p>
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <th width="33%">一级权限</th>
                                <th width="33%">二级权限</th>
                                <th width="33%">三级权限</th>
                            </thead>
                            <tbody style="text-align: center;">
                            @foreach($list as $topItem)
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
                                                        <td rowspan="{{ $secondLength }}"><a href="{{ $topModel->edit_url }}" target="_blank">{{ $topModel->name }}</a>({{ $topModel->ts_action }})</td>
                                                    @endif
                                                    @if($operateSecond == 0)
                                                        <td rowspan="{{ $operateLength }}"><a href="{{ $secondModel->edit_url }}" target="_blank">{{ $secondModel->name }}</a>({{ $secondModel->ts_action }})</td>
                                                    @endif
                                                    <td><a href="{{ $operateModel->edit_url }}" target="_blank">{{ $operateModel->name }}</a>({{ $operateModel->ts_action }})</td>
                                                    <?php $operateSecond++; ?>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                @if($countSecond == 0 && $operateSecond == 0)
                                                    <td rowspan="{{ $secondLength }}"><a href="{{ $topModel->edit_url }}" target="_blank">{{ $topModel->name }}</a>({{ $topModel->ts_action }})</td>
                                                @endif
                                                    <td rowspan="{{ $operateLength }}"><a href="{{ $secondModel->edit_url }}" target="_blank">{{ $secondModel->name }}</a>({{ $secondModel->ts_action }})</td>
                                                <td></td>
                                            </tr>
                                        @endif
                                        <?php $countSecond++; ?>
                                    @endforeach
                                @else
                                    <tr>
                                        <td><a href="{{ $topModel->edit_url }}" target="_blank">{{ $topModel->name }}</a>({{ $topModel->ts_action }})</td>
                                        <td rowspan="1"></td>
                                        <td rowspan="1"></td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection