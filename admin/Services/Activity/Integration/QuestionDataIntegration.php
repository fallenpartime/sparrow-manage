<?php
/**
 * 问题数据统计
 * Date: 2018/10/22
 * Time: 11:42
 */
namespace Admin\Services\Activity\Integration;

use Common\Models\Activity\ActivityQuestion;
use Common\Models\Activity\ActivityVote;
use Frameworks\Services\Basic\Processor\BaseWorkProcessor;

class QuestionDataIntegration extends BaseWorkProcessor
{
    protected $questionId = 0;
    protected $question = [];

    public function _init($questionId)
    {
        $this->questionId = $questionId;
        $this->question = [];
        if (!empty($questionId)) {
            $this->question = ActivityQuestion::find($questionId);
        }
        $this->status = 0;
        return $this;
    }

    public function process()
    {
        if (empty($this->question)) {
            return $this->parseResult('问题不存在', '', '');
        }
        $answerData = $this->parseAnswerInfo();
        $answerData = implode('<br>', $answerData);
        $otherData = $this->parseOtherInfo();
        $this->status = 1;
        return $this->parseResult('', $answerData, $otherData);
    }

    protected function parseAnswerInfo()
    {
        $list = [];
        $answers = $this->question->answers;
        foreach ($answers as $key => $answer) {
            $count = ActivityVote::where('answer_id', $answer->id)->where('type', 0)->count();
            $description = "选项{$key},标题:{$answer->title},投票:{$count}次";
            $list[] = $description;
        }
        return $list;
    }

    protected function parseOtherInfo()
    {
        $count = ActivityVote::where('question_id', $this->question->id)->where('type', 1)->count();
        $description = "自填信息,投票:{$count}次";
        return $description;
    }
}
