<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\traits\ModelTool;
use fredyns\suite\traits\ModelBlame;
use fredyns\suite\traits\ModelSoftDelete;
use app\models\base\MonthlyLog as BaseMonthlyLog;

/**
 * This is the model class for table "monthly_log".
 */
class MonthlyLog extends BaseMonthlyLog
{
    use ModelTool,
        ModelBlame;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(
                parent::behaviors(), [
                # custom behaviors
                ]
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(
                parent::rules(), [
                # custom validation rules
                ]
        );
    }

    /**
     * return formated date for database
     * 
     * @param string $date
     * @return string
     */
    public static function formatDate($date)
    {
        if ($date) {
            if ($dto = new \DateTime($date)) {
                return $dto->format('Y-m-01');
            }
        }

        return null;
    }

    /**
     * update daily counter
     *
     * @param string $date
     * @param integer $increment
     * @return integer
     */
    public static function counter($date, $increment)
    {
        $sql = <<<SQL

            INSERT INTO `daily_log`
            (`date`, `containerQty`)

            VALUES
            (:date, IF(:increment>0, :increment, 0))

            ON DUPLICATE KEY UPDATE
            `containerQty` = IF((`containerQty` + :increment)>0, (`containerQty` + :increment), 0)

SQL;
        if ($date) {
            return Yii::$app->db->createCommand($sql, [':date' => $date, ':increment' => $increment]);
        }

        return false;
    }

    /**
     * increment counter
     *
     * @param string $date
     * @return integer
     */
    public static function increment($date)
    {
        return static::counter($date, 1);
    }

    /**
     * decrement counter
     *
     * @param string $date
     * @return integer
     */
    public static function decrement($date)
    {
        return static::counter($date, -1);
    }
}