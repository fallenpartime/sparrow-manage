<?php
/**
 * 菜单管理
 * Date: 2018/10/3
 * Time: 20:56
 */
namespace Admin\Services\Menu;

class AdminMenuService
{
    public static function initMenuInfo($menus, $menuUrls, $isManager, $ts_list, $currentKey = '')
    {
        foreach ($menus as $key => $menu) {
            $urlKey = !empty($currentKey)? "$currentKey.$key": $key;
            if (is_array($menu)) {
                if (!empty($menu)) {
                    $menus[$key] = self::initMenuInfo($menu, $menuUrls, $isManager, $ts_list, $urlKey);
                } else {
                    continue;
                }
            } else if(empty($menu)) {
                $currentUrls = array_get($menuUrls, $urlKey);
                if (!empty($currentUrls)) {
                    foreach ($currentUrls as $currentKayName => $currentUrl) {
                        if (empty($menus[$key])) {
                            if (!empty($currentUrl) && ($isManager == 1 || in_array($currentKayName, $ts_list))) {
                                $menus[$key] = $currentUrl;
                            }
                        } else {
                            break;
                        }
                    }
                }
            } else {
                continue;
            }
        }
        return $menus;
    }
}