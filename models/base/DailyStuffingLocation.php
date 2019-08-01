<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "daily_stuffingLocation".
 *
 * @property integer $id
 * @property integer $stuffingLocation_id
 * @property string $date
 * @property integer $containerQty
 *
 * @property \app\models\StuffingLocation $stuffingLocation
 * @property string $aliasModel
 */
abstract class DailyStuffingLocation extends \yii\db\ActiveRecord
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'daily_stuffingLocation';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stuffingLocation_id', 'date'], 'required'],
            [['stuffingLocation_id', 'containerQty'], 'integer'],
            [['date'], 'safe'],
            [['stuffingLocation_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\StuffingLocation::className(), 'targetAttribute' => ['stuffingLocation_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'stuffingLocation_id' => 'Stuffing Location',
            'date' => 'Date',
            'containerQty' => 'Container Qty',
        ];
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStuffingLocation()
    {
        return $this->hasOne(\app\models\StuffingLocation::className(), ['id' => 'stuffingLocation_id']);
    }
                
}
