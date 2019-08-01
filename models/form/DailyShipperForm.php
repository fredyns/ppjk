<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\helpers\StringHelper;
use app\models\DailyShipper;

/**
 * This is the form model class for table "daily_shipper".
 */
class DailyShipperForm extends DailyShipper
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
