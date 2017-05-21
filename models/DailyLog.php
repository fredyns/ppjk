<?php

namespace app\models;

use DateTime;
use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\traits\ModelTool;
use fredyns\suite\traits\ModelBlame;
use fredyns\suite\traits\ModelSoftDelete;
use app\models\base\DailyLog as BaseDailyLog;

/**
 * This is the model class for table "daily_log".
 */
class DailyLog extends BaseDailyLog
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
     * get container quantity series log in a week
     *
     * @param integer $week
     * @return array
     */
    public static function aWeekContainerQty($week = 0)
    {
        $end = "sunday this week";

        if (is_integer($week)) {
            if ($week == 1) {
                $end = "sunday +1 week";
            } elseif ($week == -1) {
                $end = "sunday -1 week";
            } elseif ($week > 1) {
                $end = "sunday +{$week} weeks";
            } elseif ($week < -1) {
                $end = "sunday {$week} weeks";
            }
        }

        $endDate = new DateTime($end);
        $startDate = new DateTime($end);

        $startDate->modify("last monday");

        $startDay = $startDate->format('Y-m-d');
        $endDay = $endDate->format('Y-m-d');
        $logs = static::find()
            ->where([
                'and',
                ['>=', 'date', $startDay],
                ['<=', 'date', $endDay],
            ])
            ->all();
        $series = ArrayHelper::map($logs, 'date', 'containerQty');
        $data = [ArrayHelper::getValue($series, $startDay)];

        $currentDate = clone $startDate;
        while ($currentDate->getTimestamp() <= $endDate->getTimestamp()) {
            $currentDate->modify("+1 day");
            $currentDay = $currentDate->format('Y-m-d');
            $data[] = ArrayHelper::getValue($series, $currentDay);
        }

        return $data;
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