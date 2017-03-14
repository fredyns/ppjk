<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\behaviors\BelongingModelBehavior;
use fredyns\suite\helpers\StringHelper;
use app\models\ShippingInstruction;
use app\models\ContainerPort;
use app\models\CompanyProfile;

/**
 * This is the form model class for table "shippingInstruction".
 */
class ShippingInstructionForm extends ShippingInstruction
{
    public $shipperAddress;
    public $shipperPhone;
    public $shipperEmail;
    public $shipperNpwp;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(
                parent::behaviors(),
                [
                # custom behaviors
                [
                    'class' => BelongingModelBehavior::className(),
                    'relatedAttribute' => 'shipper_id',
                    'valueAttribute' => 'name',
                    'modelClass' => CompanyProfile::className(),
                    'modelAttributes' => [
                        'companyType_id' => CompanyProfile::TYPE_SHIPPER,
                    ],
                    'copyAttributes' => [
                        'address' => 'shipperAddress',
                        'phone' => 'shipperPhone',
                        'email' => 'shipperEmail',
                        'npwp' => 'shipperNpwp',
                    ],
                ],
                [
                    'class' => BelongingModelBehavior::className(),
                    'relatedAttribute' => 'shipping_id',
                    'valueAttribute' => 'name',
                    'modelClass' => CompanyProfile::className(),
                    'modelAttributes' => [
                        'companyType_id' => CompanyProfile::TYPE_SHIPPING,
                    ],
                ],
                [
                    'class' => BelongingModelBehavior::className(),
                    'modelClass' => ContainerPort::className(),
                    'relatedAttribute' => 'destination_id',
                    'valueAttribute' => 'name',
                ],
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
            [
                [
                    'shipper_id',
                    'shipperAddress',
                    'shipperPhone',
                    'shipperEmail',
                    'shipperNpwp',
                    'shipping_id',
                    'destination_id',
                ],
                'filter',
                'filter' => function($value) {

                    return StringHelper::plaintextFilter($value);
                },
            ],
            /* default value */
            ['recordStatus', 'default', 'value' => static::RECORDSTATUS_ACTIVE],
            /* required */
            [['number', 'shipper_id', 'shipping_id', 'destination_id'], 'required'],
            [
                ['shipperAddress', 'shipperPhone'],
                'required',
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->shipper_id) == FALSE);
                },
                'whenClient' => '
                    function (attribute, value) {
                        shipperInput = $(\'#'.$this->formName().'-shipper_id\').val();

                        return (shipperInput && isNaN(shipperInput));
                    }',
            ],
            /* safe */
            /* field type */
            [['number'], 'string', 'max' => 32],
            [['recordStatus'], 'string'],
            [
                ['shipper_id', 'shipping_id', 'destination_id'],
                'string',
                'max' => 255,
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->$attribute) == FALSE);
                },
            ],
            [['shipperAddress'], 'string'],
            [['shipperPhone'], 'string', 'max' => 255],
            [['shipperEmail'], 'string', 'max' => 64],
            [['shipperNpwp'], 'string', 'max' => 32],
            /* value limitation */
            ['recordStatus', 'in', 'range' => [
                    self::RECORDSTATUS_ACTIVE,
                    self::RECORDSTATUS_DELETED,
                ]
            ],
            [['shipperEmail'], 'email'],
            /* value references */
            [
                ['shipper_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => CompanyProfile::className(),
                'targetAttribute' => ['shipper_id' => 'id'],
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->$attribute));
                },
            ],
            [
                ['shipping_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => CompanyProfile::className(),
                'targetAttribute' => ['shipping_id' => 'id'],
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->$attribute));
                },
            ],
            [
                ['destination_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => ContainerPort::className(),
                'targetAttribute' => ['destination_id' => 'id'],
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->$attribute));
                },
            ],
        ];
    }
}