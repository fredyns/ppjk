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
    public static function cycle($date)
    {
        if ($date) {
            if ($dto = new \DateTime($date)) {
                return $dto->format('Y-m-01');
            }
        }

        return null;
    }

    /**
     * increment counter
     *
     * @param string $date
     * @return integer
     */
    public static function increment($date)
    {
        $sql = <<<SQL

            INSERT INTO `daily_log`
            (`date`, `containerQty`)

            VALUES
            (:date, 1)

            ON DUPLICATE KEY UPDATE
            `containerQty` = `containerQty` + 1
            ;

SQL;
        if ($date) {
            return Yii::$app->db
                    ->createCommand($sql, [':date' => $date])
                    ->execute();
        }

        return false;
    }

    /**
     * decrement counter
     *
     * @param string $date
     * @return integer
     */
    public static function decrement($date)
    {
        $sql = <<<SQL

            INSERT INTO `daily_log`
            (`date`, `containerQty`)

            VALUES
            (:date, 0)

            ON DUPLICATE KEY UPDATE
            `containerQty` = IF(`containerQty` > 0, (`containerQty` - 1), 0)

SQL;
        if ($date) {
            return Yii::$app->db
                    ->createCommand($sql, [':date' => $date])
                    ->execute();
        }

        return false;
    }
}