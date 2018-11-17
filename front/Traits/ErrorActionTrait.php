<?php
/**
 * 错误跳转
 * Date: 2018/11/3
 * Time: 15:25
 */
namespace Front\Traits;

trait ErrorActionTrait
{
    protected function errorRedirect($errorMsg, $url)
    {
        return view('front.error', ['msg'=>$errorMsg, 'url'=>$url]);
    }

    protected function errorArticleRedirect($errorMsg)
    {
        $url = '';
        $type = array_get($this->record, 'type');
        if (empty($type)) {
            $type = isset($this->type)? $this->type: 0;
        }
        if (empty($type)) {
            $type = isset($this->recordType)? $this->recordType: 0;
        }
        switch ($type) {
            case 1:
               $url = route('front.news');
               break;
            case 2:
               $url = route('front.exams');
               break;
            case 3:
               $url = route('front.practices');
               break;
            case 4:
               $url = route('front.techings');
               break;
        }
        return $this->errorRedirect($errorMsg, $url);
    }

    protected function errorActivityRedirect($errorMsg)
    {
        $url = '';
        $type = array_get($this->record, 'type');
        if (empty($type)) {
            $type = isset($this->type)? $this->type: 0;
        }
        if (empty($type)) {
            $type = isset($this->recordType)? $this->recordType: 0;
        }
        switch ($type) {
            case 1:
               $url = route('front.polls');
               break;
        }
        return $this->errorRedirect($errorMsg, $url);
    }
}
