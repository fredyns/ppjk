<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\helpers\StringHelper;
use app\models\ShippingInstruction;

/**
 * This is the form model class for table "shippingInstruction".
 */
class ShippingInstructionForm extends ShippingInstruction
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
          [['number'], 'required'],
          [['number', 'shipper_id', 'shipping_id', 'destination_id', 'deleted_at', 'deleted_by'], 'integer'],
          [['recordStatus'], 'string'],
          [['shipper_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\CompanyProfile::className(), 'targetAttribute' => ['shipper_id' => 'id']],
          [['shipping_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Shipping::className(), 'targetAttribute' => ['shipping_id' => 'id']],
          [['destination_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\ContainerPort::className(), 'targetAttribute' => ['destination_id' => 'id']],
          ['recordStatus', 'in', 'range' => [
                    self::RECORDSTATUS_ACTIVE,
                    self::RECORDSTATUS_DELETED,
                ]
            ],
        ];
    }

}
