<?php
/**
 * 获取相关联权限列表
 * Date: 2018/10/3
 * Time: 23:52
 */
namespace Admin\Services\Authority\Integration;

use Common\Models\System\AdminAction;
use Frameworks\Services\Basic\Processor\BaseWorkProcessor;

class RelateAuthoritiesIntegration extends BaseWorkProcessor
{
    protected $_menu = [];
    protected $_type = [];
    protected $withUrl = 0;

    public function __construct($type, $withUrl = 0, $columns = '')
    {
        $this->_type = $type;
        $this->withUrl = $withUrl;
        $this->_menu = AdminAction::whereIn('type', $type)->select($columns)->get();
    }

    protected function separate()
    {
        $mainMenuList = $subMenuList = $operateMenuList = [];
        foreach ($this->_menu as $menu) {
            $menuId = $menu->id;
            $menuType = $menu->type;
            if ($this->withUrl) {
                $menu->edit_url = route('authorityInfo', ['id'=>$menuId]);
            }
            if ($menuType == 1) {
                $mainMenuList[$menuId] = ['menu'=>$menu, 'length'=>0, 'list'=>[]];
            }
            if ($menuType == 2) {
                $subMenuList[$menuId] = ['menu'=>$menu, 'length'=>0, 'list'=>[]];
            }
            if (in_array(3, $this->_type)) {
                if ($menuType == 3) {
                    $operateMenuList[$menuId] = ['menu'=>$menu];
                }
            }
        }
        return [$mainMenuList, $subMenuList, $operateMenuList];
    }

    protected function combine($mainMenuList, $subMenuList, $operateMenuList)
    {
        if (in_array(3, $this->_type)) {
            foreach ($operateMenuList as $operateKey => $item) {
                $menuItem = $item['menu'];
                $parentId = $menuItem->parent_id;
                $subMenuList[$parentId]['list'][$operateKey] = $item;
                $subMenuList[$parentId]['length']++;
            }
        }
        foreach ($subMenuList as $subKey => $item) {
            $menuItem = $item['menu'];
            $item['length'] = $item['length'] == 0? 1: $item['length'];
            $parentId = $menuItem->parent_id;
            $mainMenuList[$parentId]['list'][$subKey] = $item;
            $mainMenuList[$parentId]['length'] += $item['length'];
        }
        foreach ($mainMenuList as $mainKey => $item) {
            $mainMenuList[$mainKey]['length'] = $item['length'] == 0? 1: $item['length'];
        }
        return $mainMenuList;
    }

    public function process()
    {
        $list = [];
        if (!empty($this->_menu)) {
            list($mainMenuList, $subMenuList, $operateMenuList) = $this->separate();
            $list = $this->combine($mainMenuList, $subMenuList, $operateMenuList);
        }
        if (empty($list)) {
            return $this->parseResult('权限列表为空', 0, $list);
        }
        $this->status = 1;
        return $this->parseResult('', count($list), $list);
    }
}