<?php
    $menuList = \Admin\Base\AdminMenuService::initMenuInfo(
            \Admin\Config\AdminMenuConfig::menuList(),
            \Admin\Config\AdminMenuConfig::children(),
            $admin_info['is_manager'],
            $ts_list
    );
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link href="/assets/stylesheets/bootstrap.min.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/assets/stylesheets/se7en-font.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/assets/stylesheets/datatables.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/assets/stylesheets/style.css" media="all" rel="stylesheet" type="text/css" />
    <script src="/assets/javascripts/jquery-1.10.2.min.js" type="text/javascript"></script>
    <script src="/assets/javascripts/jquery-ui.js" type="text/javascript"></script>
    <script src="/assets/javascripts/bootstrap.min.js" type="text/javascript"></script>
    <script src="/assets/javascripts/jquery.sparkline.min.js" type="text/javascript"></script>
    <script src="/assets/javascripts/jquery.isotope.min.js" type="text/javascript"></script>
    <script src="/assets/javascripts/main.js" type="text/javascript"></script>

    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</head>
<body>
<div class="modal-shiftfix">
    @include('admin.menus.main', ['menu' => $menu, 'menu_urls' => $menuList, 'admin_info' => $admin_info, 'ts_list' => $ts_list])
    @yield('body_content')
</div>
</body>
</html>