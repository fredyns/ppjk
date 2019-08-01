<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\helpers\StringHelper;
use app\models\MonthlyDestination;

/**
 * This is the form model class for table "monthly_destination".
 */
class MonthlyDestinationForm extends MonthlyDestination
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
          [['destination_id'], 'required'],
          [['destination_id', 'containerQty'], 'integer'],
          [['destination_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\ContainerPort::className(), 'targetAttribute' => ['destination_id' => 'id']],
        ];
    }

}
