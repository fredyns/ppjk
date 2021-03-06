<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\helpers\StringHelper;
use app\models\DailyStuffingLocation;

/**
 * This is the form model class for table "daily_stuffingLocation".
 */
class DailyStuffingLocationForm extends DailyStuffingLocation
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
          /* filter */
          /* default value */
          /* required */
          /* safe */
          /* field type */
          /* value limitation */
          /* value references */
          [['stuffingLocation_id', 'date'], 'required'],
          [['stuffingLocation_id', 'containerQty'], 'integer'],
          [['date'], 'safe'],
          [['stuffingLocation_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\StuffingLocation::className(), 'targetAttribute' => ['stuffingLocation_id' => 'id']],
        ];
    }

}
