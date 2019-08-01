<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "monthly_log".
 *
 * @property string $month
 * @property integer $containerQty
 * @property string $aliasModel
 */
abstract class MonthlyLog extends \yii\db\ActiveRecord
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'monthly_log';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['month'], 'required'],
            [['month'], 'safe'],
            [['containerQty'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'month' => 'Month',
            'containerQty' => 'Container Qty',
        ];
    }
                    
}
