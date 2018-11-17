<?php
/**
 * 权限不足预警
 * Date: 2018/10/2
 * Time: 23:21
 */
namespace App\Http\Admin\Actions\Site;

use Admin\Actions\BaseAction;

class WarnAction extends BaseAction
{
    public function run()
    {
        return view('admin.site.warn', ['message'=>'权限不足']);
    }
}
