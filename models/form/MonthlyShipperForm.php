<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\helpers\StringHelper;
use app\models\MonthlyShipper;

/**
 * This is the form model class for table "monthly_shipper".
 */
class MonthlyShipperForm extends MonthlyShipper
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
          [['shipper_id', 'date'], 'required'],
          [['shipper_id', 'containerQty'], 'integer'],
          [['date'], 'safe'],
          [['shipper_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\CompanyProfile::className(), 'targetAttribute' => ['shipper_id' => 'id']],
        ];
    }

}
