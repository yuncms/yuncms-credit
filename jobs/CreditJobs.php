<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace yuncms\credit\jobs;

use Yii;
use yii\base\Object;
use yii\queue\RetryableJob;
use yuncms\credit\models\Credit;
use yuncms\user\models\Extend;

/**
 * 异步更新用户经验任务类
 */
class CreditJobs extends Object implements RetryableJob
{
    /**
     * @var string 操作
     */
    public $action;

    /**
     * @var int 用户ID
     */
    public $user_id;

    /**
     * @var integer|float
     */
    public $credits;

    /**
     * @var int 模型ID
     */
    public $modelId;

    /**
     * @var string 模型标题
     */
    public $modelSubject;

    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
        $extend = Extend::findOne($this->userId);
        if ($extend) {
            $transaction = Extend::getDb()->beginTransaction();
            try {
                $extend->updateCounters(['credits' => $this->credits]);
                Credit::create([
                    'user_id' => $this->user_id,
                    'action' => $this->action,
                    'model_id' => $this->modelId,
                    'model_subject' => $this->modelSubject,
                    'credits' => $this->credits,
                ]);
                $transaction->commit();
                return true;
            } catch (\Exception $e) {
                $transaction->rollBack();
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function getTtr()
    {
        return 60;
    }

    /**
     * @inheritdoc
     */
    public function canRetry($attempt, $error)
    {
        return $attempt < 3;
    }
}