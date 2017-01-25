<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\helpers\StringHelper;
use app\models\JobContainer;

/**
 * This is the form model class for table "jobContainer".
 */
class JobContainerForm extends JobContainer
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
          [['shippingInstruction_id', 'stuffingLocation_id', 'driver_id', 'supervisor_id', 'deleted_at', 'deleted_by'], 'integer'],
          [['stuffingDate'], 'safe'],
          [['recordStatus'], 'string'],
          [['containerNumber'], 'string', 'max' => 32],
          [['sealNumber'], 'string', 'max' => 64],
          [['shippingInstruction_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\ShippingInstruction::className(), 'targetAttribute' => ['shippingInstruction_id' => 'id']],
          [['stuffingLocation_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\StuffingLocation::className(), 'targetAttribute' => ['stuffingLocation_id' => 'id']],
          [['driver_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Profile::className(), 'targetAttribute' => ['driver_id' => 'id']],
          [['supervisor_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\TruckSupervisor::className(), 'targetAttribute' => ['supervisor_id' => 'id']],
          ['recordStatus', 'in', 'range' => [
                    self::RECORDSTATUS_ACTIVE,
                    self::RECORDSTATUS_DELETED,
                ]
            ],
        ];
    }

}
