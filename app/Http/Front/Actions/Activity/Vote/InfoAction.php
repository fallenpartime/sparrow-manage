<?php
/**
 * 投票页面（保存）
 * Date: 2018/10/30
 * Time: 1:51
 */
namespace App\Http\Front\Actions\Activity\Vote;

use Admin\Config\ActivityConfig;
use Admin\Models\Activity\ActivityQuestion;
use Admin\Services\Activity\Processor\ActivityVoteProcessor;
use Admin\Traits\ApiActionTrait;
use Front\Actions\BaseAction;
use Front\Traits\ActivityActionTrait;
use Front\Traits\ErrorActionTrait;
use Illuminate\Support\Facades\Redis;
use Wechat\Traits\WechatDefaultOauthTrait;

class InfoAction extends BaseAction
{
    use ActivityActionTrait, ApiActionTrait, WechatDefaultOauthTrait, ErrorActionTrait;

    protected $thankUrl = '';
    protected $voteKey = '';

    public function run()
    {
        $this->init();
        if (!$this->initRecordByCode()) {
            if ($this->request->isMethod('post')) {
                $this->errorJson(500, '活动不见啦');
            } else {
                return $this->errorActivityRedirect('活动不见啦');
            }
        }
        $this->initVoteParams();
        $isAjax = 0;
        if ($this->request->ajax()) {
            $isAjax = 1;
        }
        if (Redis::sismember($this->voteKey, $this->userId)) {
            if ($isAjax) {
                $this->errorJson(500, ['url'=>$this->thankUrl]);
            } else {
                header("Location: ". url()->previous());
                exit();
            }
        }
        if ($this->request->isMethod('post')) {
            $this->process();
        }
        $service = $this->getService();
        $code = $service->getCode(array_get($this->record, 'id'), array_get($this->record, 'type'));
        $questions = ActivityQuestion::where(['activity_id'=>array_get($this->record, 'id'), 'is_show'=>1])->with('answers')->get();
        $result = [
            'record'        =>  $this->record,
            'questions'     =>  $questions,
            'vote_url'      =>  route('front.activity.vote', ['code'=>$code]),
        ];
        return view('front.activity.vote.index', $result);
    }

    protected function initVoteParams()
    {
        $this->voteKey = ActivityConfig::VOTE_PREFIX.array_get($this->record, 'id');
        $code = $this->getService()->getCode(array_get($this->record, 'id'), array_get($this->record, 'type'));
        $this->thankUrl = route('front.activity.feedback', ['code'=>$code]);
    }

    protected function process()
    {
        $votes = [];
        $answerBoxes = $this->request->get('answer_box');
        $answerSingles = $this->request->get('answer_single');
        $others = $this->request->get('answer_other');
        if (!empty($answerBoxes)) {
            foreach ($answerBoxes as $answer) {
                list($questionId, $answerId) = explode('-', $answer);
                $unit = [
                    'activity_id'   =>  array_get($this->record, 'id'),
                    'user_id'   =>  $this->userId,
                    'type'      =>  0,
                    'question_id'   =>  $questionId,
                    'answer_id'     =>  $answerId,
                ];
                $votes[] = $unit;
            }
        }
        if (!empty($answerSingles)) {
            foreach ($answerSingles as $answer) {
                list($questionId, $answerId) = explode('-', $answer);
                $unit = [
                    'activity_id'   =>  array_get($this->record, 'id'),
                    'user_id'   =>  $this->userId,
                    'type'      =>  0,
                    'question_id'   =>  $questionId,
                    'answer_id'     =>  $answerId,
                ];
                $votes[] = $unit;
            }
        }
        if (!empty($others)) {
            foreach ($others as $questionId => $other) {
                $other = trim($other);
                if (!empty($other)) {
                    $unit = [
                        'activity_id'   =>  array_get($this->record, 'id'),
                        'user_id'   =>  $this->userId,
                        'type'      =>  1,
                        'question_id'   =>  $questionId,
                        'other'     =>  $other,
                    ];
                    $votes[] = $unit;
                }
            }
        }
        if (Redis::sismember($this->voteKey, $this->userId)) {
            if ($this->request->ajax()) {
                $this->errorJson(500, ['url'=>$this->thankUrl]);
            }
        }
        if (!empty($votes)) {
            $processor = new ActivityVoteProcessor();
            foreach ($votes as $vote) {
                $processor->insert($vote);
            }
        }
        Redis::sadd($this->voteKey, $this->userId);
        $this->successJson('', ['url'=>$this->thankUrl]);
    }
}
