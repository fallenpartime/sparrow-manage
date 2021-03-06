<?php
/**
 * 投票详情页
 * Date: 2018/10/30
 * Time: 1:49
 */
namespace App\Http\Front\Actions\Activity\Poll;

use Common\Config\ActivityConfig;
use Front\Action\BaseAction;
use Front\Traits\ActivityActionTrait;
use Front\Traits\ErrorActionTrait;
use Front\Traits\LoginAuthTrait;
use Illuminate\Support\Facades\Redis;

class InfoAction extends BaseAction
{
    use LoginAuthTrait, ActivityActionTrait, ErrorActionTrait;

    protected $type = 1;
    protected $voteKey = '';

    public function run()
    {
        $this->init();
        if (!$this->initRecordByCode()) {
            return $this->errorActivityRedirect('活动不见啦');
        }
        $service = $this->getService();
        $service->readCounter();
        $code = $service->getCode(array_get($this->record, 'id'), array_get($this->record, 'type'));
        // 是否允许投票
        list($allowVote, $voteUrl) = $this->allowVote($code);
        $result = [
            'record'        =>  $this->record,
            'like_url'      =>  $this->likeUrl,
            'allow_vote'    =>  $allowVote,
            'vote_url'      =>  $voteUrl,
        ];
        return view('front.activity.poll.info', $result);
    }

    protected function allowVote($code)
    {
        $this->voteKey = ActivityConfig::VOTE_PREFIX.array_get($this->record, 'id');
        $allowVote = 0;
        $voteUrl = '';
        $openStatus = array_get($this->record, 'is_open');
        $overedAt = array_get($this->record, 'overed_at');
        if ($openStatus == 1 && empty($overedAt)) {
            if (!Redis::sismember($this->voteKey, $this->userId)) {
                $allowVote = 1;
                $voteUrl = route('front.activity.vote', ['code'=>$code]);
            }
        }
        return [$allowVote, $voteUrl];
    }
}
