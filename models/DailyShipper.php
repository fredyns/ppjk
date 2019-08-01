<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\traits\ModelTool;
use fredyns\suite\traits\ModelBlame;
use fredyns\suite\traits\ModelSoftDelete;
use app\models\base\DailyShipper as BaseDailyShipper;

/**
 * This is the model class for table "daily_shipper".
 */
class DailyShipper extends BaseDailyShipper
{
    use ModelTool,
        ModelBlame;
    const ALIAS_SHIPPER = 'shipper';

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
     * @return \yii\db\ActiveQuery
     */
    public function getShipper()
    {
        return parent::getShipper()->alias(static::ALIAS_SHIPPER);
    }

    /**
     * increment counter
     *
     * @param string $date
     * @return integer
     */
    public static function increment($shipper_id, $date)
    {
        $sql = <<<SQL

            INSERT INTO `daily_shipper`
            (`shipper_id`, `date`, `containerQty`)

            VALUES
            (:shipper_id, :date, 1)

            ON DUPLICATE KEY UPDATE
            `containerQty` = `containerQty` + 1

SQL;
        if ($shipper_id > 0 && $date) {
            return Yii::$app->db
                    ->createCommand($sql, [':shipper_id' => $shipper_id, ':date' => $date])
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
    public static function decrement($shipper_id, $date)
    {
        $sql = <<<SQL

            INSERT INTO `daily_shipper`
            (`shipper_id`, `date`, `containerQty`)

            VALUES
            (:shipper_id, :date, 0)

            ON DUPLICATE KEY UPDATE
            `containerQty` = IF(`containerQty` > 0, (`containerQty` - 1), 0)

SQL;
        if ($shipper_id > 0 && $date) {
            return Yii::$app->db
                    ->createCommand($sql, [':shipper_id' => $shipper_id, ':date' => $date])
                    ->execute();
        }

        return false;
    }
}