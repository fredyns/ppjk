<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\behaviors\BelongingModelBehavior;
use fredyns\suite\helpers\StringHelper;
use app\models\JobContainer;
use app\models\CompanyProfile;
use app\models\ShippingInstruction;
use app\models\StuffingLocation;
use app\models\TruckSupervisor;
use app\models\ContainerType;
use app\models\ContainerPort;

/**
 * This is the form model class for table "jobContainer".
 */
class JobContainerForm extends JobContainer
{
    const NEWSI_YES = 'yes';
    const NEWSI_NO = 'no';

    public $newSi = 'no';
    public $shippingInstructionNumber;
    public $shipperId;
    public $shipperAddress;
    public $shipperPhone;
    public $shipperEmail;
    public $shipperNpwp;
    public $shippingId;
    public $destinationId;
    public $supervisorPhone;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(
                parent::attributeLabels(),
                [
                'shippingInstructionNumber' => 'SI Number',
                'shipperId' => 'Shipper Name',
                'shipperAddress' => 'Shipper Address',
                'shipperPhone' => 'Shipper Phone',
                'shipperEmail' => 'Shipper Email',
                'shipperNpwp' => 'Shipper NPWP',
                'shippingId' => 'Shipping Name',
                'destinationId' => 'Destination Name',
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
                    // new SI
                    'shippingInstructionNumber',
                    'shipperId', 'shipperAddress', 'shipperPhone', 'shipperEmail', 'shipperNpwp',
                    'shippingId', 'destinationId',
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
                    'shippingInstructionNumber',
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
            ['newSi', 'default', 'value' => static::NEWSI_NO],
            ['recordStatus', 'default', 'value' => static::RECORDSTATUS_ACTIVE],
            /* required */
            [
                ['shippingInstruction_id'],
                'required',
                'when' => function ($model, $attribute) {
                    return ($model->newSi == 'no');
                },
                'whenClient' => '
                    function (attribute, value) {
                        newsi = $(\'input[name="JobContainerForm[newSi]"]:checked.newsi-opts\').val();

                        return (newsi == \''.static::NEWSI_NO.'\');
                    }',
            ],
            [
                ['shippingInstructionNumber', 'shipperId'],
                'required',
                'when' => function ($model, $attribute) {
                    return ($model->newSi == static::NEWSI_YES);
                },
                'whenClient' => '
                    function (attribute, value) {
                        newsi = $(\'input[name="JobContainerForm[newSi]"]:checked.newsi-opts\').val();

                        return (newsi == \''.static::NEWSI_YES.'\');
                    }',
            ],
            [
                ['shipperAddress', 'shipperPhone'],
                'required',
                'when' => function ($model, $attribute) {
                    $newSi = ($model->newSi == static::NEWSI_YES);
                    $newShipper = (is_numeric($model->shipperId) == FALSE);

                    return ($newSi && $newShipper);
                },
                'whenClient' => '
                    function (attribute, value) {
                        newsi = $(\'input[name="JobContainerForm[newSi]"]:checked.newsi-opts\').val();
                        shipperInput = $(\'#'.$this->formName().'-shipperId\').val();

                        return (newsi == \''.static::NEWSI_YES.'\' && shipperInput && isNaN(shipperInput));
                    }',
            ],
            [
                ['supervisorPhone'],
                'required',
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->supervisor_id) == FALSE);
                },
                'whenClient' => '
                    function (attribute, value) {
                        supervisorInput = $(\'#'.$this->formName().'-supervisorId\').val();

                        return (supervisorInput && isNaN(supervisorInput));
                    }',
            ],
            /* safe */
            /* field type */
            [['shippingInstruction_id', 'type_id'], 'integer'],
            [['size', 'recordStatus', 'notes'], 'string'],
            [['containerNumber'], 'string', 'max' => 12],
            [['policenumber'], 'string', 'max' => 16],
            [
                [
                    // new si
                    'shippingInstructionNumber',
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
                    'shipperId', 'shippingId', 'destinationId',
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
            [['stuffingDate'], 'date', 'format' => 'php:Y-m-d'],
            ['newSi', 'in', 'range' => [
                    self::NEWSI_YES,
                    self::NEWSI_NO,
                ]
            ],
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
            [
                ['shippingInstructionNumber'],
                'unique',
                'targetAttribute' => 'number',
                'targetClass' => ShippingInstruction::className(),
                'when' => function ($model, $attribute) {
                    return ($model->newSi == static::NEWSI_YES);
                },
                'whenClient' => '
                    function (attribute, value) {
                        newsi = $(\'input[name="JobContainerForm[newSi]"]:checked.newsi-opts\').val();

                        return (newsi === \''.static::NEWSI_YES.'\');
                    }',
            ],
            [['shipperEmail'], 'email'],
            /* value references */
            [
                ['shippingInstruction_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => ShippingInstruction::className(),
                'targetAttribute' => ['shippingInstruction_id' => 'id'],
                'when' => function ($model, $attribute) {
                    return ($model->newSi == static::NEWSI_NO);
                },
            ],
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
                ['shipperId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => CompanyProfile::className(),
                'targetAttribute' => ['shipperId' => 'id'],
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->$attribute));
                },
            ],
            [
                ['shippingId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => CompanyProfile::className(),
                'targetAttribute' => ['shippingId' => 'id'],
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->$attribute));
                },
            ],
            [
                ['destinationId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => ContainerPort::className(),
                'targetAttribute' => ['destinationId' => 'id'],
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->$attribute));
                },
            ],
        ];
    }

    /**
     * get column newSi enum value label
     * @param string $value
     * @return string
     */
    public static function getNewSi($value)
    {
        $labels = self::optsNewSi();

        if (isset($labels[$value])) {
            return $labels[$value];
        }

        return $value;
    }

    /**
     * column newSi ENUM value labels
     * @return array
     */
    public static function optsNewSi()
    {
        return [
            self::NEWSI_NO => 'No',
            self::NEWSI_YES => 'Yes',
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        $mirrorAttributes = [
            // SI field => Container field
            'number' => 'shippingInstructionNumber',
            'shipper_id' => 'shipperId',
            'shipperAddress' => 'shipperAddress',
            'shipperPhone' => 'shipperPhone',
            'shipperEmail' => 'shipperEmail',
            'shipperNpwp' => 'shipperNpwp',
            'shipping_id' => 'shippingId',
            'destination_id' => 'destinationId',
        ];

        if ($this->newSi == static::NEWSI_YES) {
            $shippingInstruction = new ShippingInstructionForm;
            $shippingInstruction->copy($this, $mirrorAttributes);

            if ($shippingInstruction->save(false)) {
                $this->shippingInstruction_id = $shippingInstruction->id;
            } else {
                $msg = 'Shipping Instruction error.<br/>'.implode('<br/>', $shippingInstruction->getErrors());
                $this->addError('_exception', $msg);

                return false;
            }
        }

        return parent::beforeSave($insert);
    }
}