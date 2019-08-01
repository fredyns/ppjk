<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\helpers\StringHelper;
use app\models\DailyTruckSupervising;

/**
 * This is the form model class for table "daily_truckSupervising".
 */
class DailyTruckSupervisingForm extends DailyTruckSupervising
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
          [['supervisor_id'], 'required'],
          [['supervisor_id', 'containerQty'], 'integer'],
          [['supervisor_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\TruckSupervisor::className(), 'targetAttribute' => ['supervisor_id' => 'id']],
        ];
    }

}
