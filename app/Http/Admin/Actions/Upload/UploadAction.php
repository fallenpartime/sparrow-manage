<?php
/**
 * 单图上传
 * Date: 2018/10/8
 * Time: 14:38
 */
namespace App\Http\Admin\Actions\Upload;

use Admin\Actions\BaseAction;
use Admin\Component\Upload\Processor\UploadProcessor;
use Admin\Traits\ApiActionTrait;

class UploadAction extends BaseAction
{
    use ApiActionTrait;

    public function run()
    {
        $processor = new UploadProcessor();
        list($status, $message, $path, $originalName, $targetFileName) = $processor->_init($this->request)->process();
        $pathUrl = '/storage/'.$path;
        $result = [
            'jsonrpc'   =>  '2.0',
            'result'    =>  '',
            'tempname'  =>  $originalName,
            'name'      =>  $targetFileName,
            'src'       =>  $pathUrl,
            'thumb'     =>  $pathUrl,
            'id'        =>  'id',
        ];
        $this->customJson($result);
    }
}
