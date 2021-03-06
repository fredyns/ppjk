<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\helpers\StringHelper;
use app\models\MonthlyDriving;

/**
 * This is the form model class for table "monthly_driving".
 */
class MonthlyDrivingForm extends MonthlyDriving
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
          [['driver_id'], 'required'],
          [['driver_id', 'containerQty', 'kilometerage'], 'integer'],
          [['driver_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\CompanyProfile::className(), 'targetAttribute' => ['driver_id' => 'id']],
        ];
    }

}
