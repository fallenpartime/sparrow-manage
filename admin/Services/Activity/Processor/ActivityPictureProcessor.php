<?php
/**
 * 活动图片
 * Date: 2018/10/4
 * Time: 16:15
 */
namespace Admin\Services\Activity\Processor;

use Common\Models\Activity\ActivityPicture;
use Frameworks\Services\Basic\Processor\BaseProcessor;

class ActivityPictureProcessor extends BaseProcessor
{
    protected $tableName = 'activity_pictures';
    protected $tableClass = ActivityPicture::class;
}