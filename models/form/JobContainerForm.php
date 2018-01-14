<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\behaviors\BelongingModelBehavior;
use fredyns\suite\helpers\StringHelper;
use app\behaviors\SIBehavior;
use app\models\JobContainer;
use app\models\CompanyProfile;
use app\models\ShippingInstruction;
use app\models\StuffingLocation;
use app\models\TruckSupervisor;
use app\models\ContainerType;
use app\models\ContainerPort;
use app\models\DailyLog;
use app\models\DailyShipper;
use app\models\MonthlyLog;
use app\models\MonthlyShipper;
use app\models\form\ShippingInstructionForm;

/**
 * This is the form model class for table "jobContainer".
 *
 * @property ShippingInstructionForm $shippingInstruction
 */
class JobContainerForm extends JobContainer
{
    public $shipperAddress;
    public $shipperPhone;
    public $shipperEmail;
    public $shipperNpwp;
    public $supervisorPhone;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(
                parent::attributeLabels(),
                [
                'shipperAddress' => 'Shipper Address',
                'shipperPhone' => 'Shipper Phone',
                'shipperEmail' => 'Shipper Email',
                'shipperNpwp' => 'Shipper NPWP',
                'supervisorPhone' => 'Mandor Phone',
                ]
        );
    }

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
                [
                    'class' => BelongingModelBehavior::className(),
                    'relatedAttribute' => 'containerDepo_id',
                    'valueAttribute' => 'name',
                    'modelClass' => CompanyProfile::className(),
                    'modelAttributes' => [
                        'companyType_id' => CompanyProfile::TYPE_DEPO,
                    ],
                ],
                [
                    'class' => BelongingModelBehavior::className(),
                    'relatedAttribute' => 'stuffingLocation_id',
                    'valueAttribute' => 'name',
                    'modelClass' => StuffingLocationForm::className(),
                ],
                [
                    'class' => BelongingModelBehavior::className(),
                    'modelClass' => TruckSupervisorForm::className(),
                    'relatedAttribute' => 'supervisor_id',
                    'valueAttribute' => 'name',
                    'copyAttributes' => [
                        'phone' => 'supervisorPhone',
                    ],
                ],
                [
                    'class' => BelongingModelBehavior::className(),
                    'relatedAttribute' => 'truckVendor_id',
                    'valueAttribute' => 'name',
                    'modelClass' => CompanyProfile::className(),
                    'modelAttributes' => [
                        'companyType_id' => CompanyProfile::TYPE_TRUCKVENDOR,
                    ],
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
                    // SI
                    'deliveryOrder',
                    'shipper_id', 'shipperAddress', 'shipperPhone', 'shipperEmail', 'shipperNpwp',
                    'shipping_id', 'destination_id',
                    // container
                    'containerNumber', 'sealNumber',
                    'containerDepo_id', 'stuffingLocation_id', 'supervisor_id', 'truckVendor_id',
                    'driverName', 'cellphone', 'policenumber', 'notes',
                    // supervisor
                    'supervisorPhone',
                ],
                'filter',
                'filter' => function($value) {
                    return StringHelper::plaintextFilter($value);
                },
            ],
            [
                [
                    // new SI
                    'deliveryOrder', 'shipper_id',
                    'shipping_id', 'destination_id',
                    // container
                    'containerNumber', 'sealNumber',
                    'policenumber',
                ],
                'filter',
                'filter' => function($value) {
                    return strtoupper($value);
                },
            ],
            /* default value */
            ['recordStatus', 'default', 'value' => static::RECORDSTATUS_ACTIVE],
            /* required */
            [['deliveryOrder','shipper_id'], 'required'],
            [
                ['shipperAddress', 'shipperPhone'],
                'required',
                'when' => function ($model, $attribute) {
                    $newShipper = (is_numeric($model->shipper_id) == FALSE);

                    return ($newShipper);
                },
                'whenClient' => '
                    function (attribute, value) {
                        shipper = $(\'#'.$this->formName().'-shipper_id\').val();

                        return (shipper && isNaN(shipper));
                    }',
            ],
            [
                ['supervisorPhone'],
                'required',
                'when' => function ($model, $attribute) {
                    return ($model->supervisor_id && is_numeric($model->supervisor_id) == FALSE);
                },
                'whenClient' => '
                    function (attribute, value) {
                        supervisorInput = $(\'#'.$this->formName().'-supervisor_id\').val();

                        return (supervisorInput && isNaN(supervisorInput));
                    }',
            ],
            /* safe */
            /* field type */
            [['type_id'], 'integer'],
            [['size', 'recordStatus', 'notes'], 'string'],
            [['deliveryOrder', 'containerNumber'], 'string', 'max' => 12],
            [['policenumber'], 'string', 'max' => 16],
            [
                [
                    // container
                    'sealNumber',
                    'cellphone',
                    // supervisor
                    'supervisorPhone',
                ],
                'string',
                'max' => 32,
            ],
            [['driverName'], 'string', 'max' => 255],
            [
                [
                    // new si
                    'shipper_id', 'shipping_id', 'destination_id',
                    // container
                    'containerDepo_id', 'stuffingLocation_id', 'supervisor_id', 'truckVendor_id',
                ],
                'string',
                'max' => 255,
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->$attribute) == FALSE);
                },
            ],
            // shipper
            [['shipperAddress'], 'string'],
            [['shipperPhone'], 'string', 'max' => 255],
            [['shipperEmail'], 'string', 'max' => 64],
            [['shipperNpwp'], 'string', 'max' => 32],
            /* value limitation */
            [
                ['deliveryOrder'],
                'match',
                'pattern' => static::DOPATTERN,
                'message' => 'Format Delivery Order tidak sesuai.'
            ],
            [['stuffingDate'], 'date', 'format' => 'php:Y-m-d'],
            ['size', 'in', 'range' => [
                    self::SIZE_20,
                    self::SIZE_40,
                    self::SIZE_45,
                    self::SIZE_LCL,
                ]
            ],
            ['recordStatus', 'in', 'range' => [
                    self::RECORDSTATUS_ACTIVE,
                    self::RECORDSTATUS_DELETED,
                ]
            ],
            [['shipperEmail'], 'email'],
            /* value references */
            [
                ['type_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => ContainerType::className(),
                'targetAttribute' => ['type_id' => 'id'],
            ],
            [
                ['containerDepo_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => CompanyProfile::className(),
                'targetAttribute' => ['containerDepo_id' => 'id'],
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->$attribute));
                },
            ],
            [
                ['stuffingLocation_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => StuffingLocation::className(),
                'targetAttribute' => ['stuffingLocation_id' => 'id'],
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->$attribute));
                },
            ],
            [
                ['supervisor_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => TruckSupervisor::className(),
                'targetAttribute' => ['supervisor_id' => 'id'],
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->$attribute));
                },
            ],
            [
                ['truckVendor_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => CompanyProfile::className(),
                'targetAttribute' => ['truckVendor_id' => 'id'],
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->$attribute));
                },
            ],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShippingInstruction()
    {
        return $this->hasOne(ShippingInstructionForm::className(), ['id' => 'shippingInstruction_id']);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        $this->pushCounter();

        return parent::beforeSave($insert);
    }

    /**
     * update all counter
     */
    public function pushCounter()
    {
        // daily counter
        $oldDate = $this->getOldAttribute('stuffingDate');
        $newDate = $this->getAttribute('stuffingDate');

        if ($oldDate != $newDate) {
            DailyLog::decrement($oldDate);
            DailyLog::increment($newDate);
        }

        // monthly counter
        $oldMonth = MonthlyLog::cycle($oldDate);
        $newMonth = MonthlyLog::cycle($newDate);

        if ($oldMonth != $newMonth) {
            MonthlyLog::decrement($oldMonth);
            MonthlyLog::increment($newMonth);
        }

        // daily shipper
        $oldShipper = $this->getOldAttribute('shipper_id');
        $newShipper = $this->shipper_id;

        if ($oldDate != $newDate OR $oldShipper != $newShipper) {
            DailyShipper::decrement($oldShipper, $oldDate);
            DailyShipper::increment($newShipper, $newDate);
        }

        // monthly shipper
        if ($oldMonth != $newMonth OR $oldShipper != $newShipper) {
            MonthlyShipper::decrement($oldShipper, $oldMonth);
            MonthlyShipper::increment($newShipper, $newMonth);
        }
        //Yii::$app->getSession()->addFlash('info', "old: {$oldShipper}; new: {$newShipper};");
    }
}