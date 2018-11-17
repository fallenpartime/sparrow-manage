<?php
/**
 * 相关权限选中情况
 * Date: 2018/10/4
 * Time: 21:10
 */
namespace Admin\Services\Authority\Integration;

use Frameworks\Services\Basic\Processor\BaseWorkProcessor;

class RelateAuthoritiesCheckedIntegration extends BaseWorkProcessor
{
    protected $_menus = [];
    protected $_checked = [];

    public function __construct($menus, $checked)
    {
        $this->_init($menus, $checked);
    }

    public function _init($menus, $checked)
    {
        $this->_menus = $menus;
        $this->_checked = $checked;
    }

    protected function appendChecked($menus)
    {
        if (!empty($menus)) {
            foreach ($menus as $key => $menu) {
                $checked = in_array($menu['menu']->ts_action, $this->_checked);
                $menus[$key]['menu']->is_checked = $checked;
                if (!empty($menu['list'])) {
                    $menus[$key]['list'] = $this->appendChecked($menu['list']);
                }
            }
        }
        return $menus;
    }

    public function process()
    {
        if (!empty($this->_menus) && empty($this->_checked)) {
            $this->status = 1;
            $this->parseResult(count($this->_menus), $this->_menus);
        }
        $list = $this->appendChecked($this->_menus);
        if (empty($list)) {
            return $this->parseResult('数据为空', []);
        }
        $this->status = 1;
        return $this->parseResult(count($list), $list);
    }
}