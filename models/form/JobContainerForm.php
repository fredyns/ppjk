<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\behaviors\BelongingModelBehavior;
use fredyns\suite\helpers\StringHelper;
use app\behaviors\DriverBehavior;
use app\models\JobContainer;

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
    public $driverPhone;

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
                    'modelClass' => StuffingLocationForm::className(),
                    'relatedAttribute' => 'stuffingLocation_id',
                    'valueAttribute' => 'name',
                ],
                [
                    'class' => BelongingModelBehavior::className(),
                    'modelClass' => TruckSupervisorForm::className(),
                    'relatedAttribute' => 'supervisor_id',
                    'valueAttribute' => 'name',
                ],
                [
                    'class' => DriverBehavior::className(),
                    'driverTitle' => 'Sopir',
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
                    'newSi',
                    'shippingInstructionNumber',
                    'containerNumber', 'sealNumber', 'worknote',
                    'stuffingLocation_id', 'supervisor_id',
                    'shipperId', 'shippingId', 'destinationId',
                    'shipperAddress', 'shipperPhone', 'shipperEmail', 'shipperNpwp',
                    'driver_id', 'driverPhone',
                ],
                'filter',
                'filter' => function($value) {

                    return StringHelper::plaintextFilter($value);
                },
            ],
            /* default value */
            ['newSi', 'default', 'value' => static::NEWSI_NO],
            ['recordStatus', 'default', 'value' => static::RECORDSTATUS_ACTIVE],
            /* required */
            [['containerNumber'], 'required'],
            [
                ['shippingInstruction_id'],
                'required',
                'when' => function ($model, $attribute) {
                    return ($model->newSi == 'no');
                },
                'whenClient' => '
                    function (attribute, value) {
                        newsi = $(\'input[name="JobContainerForm[newSi]"]:checked\').val();

                        return (newsi == \''.static::NEWSI_NO.'\');
                    }',
            ],
            [
                ['shippingInstructionNumber', 'shipperId', 'shippingId', 'destinationId'],
                'required',
                'when' => function ($model, $attribute) {
                    return ($model->newSi == static::NEWSI_YES);
                },
                'whenClient' => '
                    function (attribute, value) {
                        newsi = $(\'input[name="JobContainerForm[newSi]"]:checked\').val();

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
                        newsi = $(\'input[name="JobContainerForm[newSi]"]:checked\').val();
                        shipperInput = $(\'#'.$this->formName().'-shipperId\').val();

                        return (newsi == \''.static::NEWSI_YES.'\' && shipperInput && isNaN(shipperInput));
                    }',
            ],
            /* safe */
            /* field type */
            [['shippingInstruction_id'], 'integer'],
            [['recordStatus', 'worknote'], 'string'],
            [['shippingInstructionNumber', 'containerNumber'], 'string', 'max' => 32],
            [['sealNumber', 'driverPhone'], 'string', 'max' => 64],
            [
                [
                    'stuffingLocation_id', 'supervisor_id',
                    'shipperId', 'shippingId', 'destinationId',
                    'driver_id',
                ],
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
            [['stuffingDate'], 'date', 'format' => 'php:Y-m-d'],
            ['newSi', 'in', 'range' => [
                    self::NEWSI_YES,
                    self::NEWSI_NO,
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
                'targetClass' => \app\models\ShippingInstruction::className(),
                'when' => function ($model, $attribute) {
                    return ($model->newSi == static::NEWSI_YES);
                },
                'whenClient' => '
                    function (attribute, value) {
                        newsi = $(\'#'.$this->formName().'-newsi\').val();

                        return (newsi === \''.static::NEWSI_YES.'\');
                    }',
            ],
            [['shipperEmail'], 'email'],
            /* value references */
            [
                ['shippingInstruction_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \app\models\ShippingInstruction::className(),
                'targetAttribute' => ['shippingInstruction_id' => 'id'],
                'when' => function ($model, $attribute) {
                    return ($model->newSi == static::NEWSI_NO);
                },
            ],
            [
                ['stuffingLocation_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \app\models\StuffingLocation::className(),
                'targetAttribute' => ['stuffingLocation_id' => 'id'],
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->$attribute));
                },
            ],
            [
                ['driver_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \app\models\Profile::className(),
                'targetAttribute' => ['driver_id' => 'id'],
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->$attribute));
                },
            ],
            [
                ['supervisor_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \app\models\TruckSupervisor::className(),
                'targetAttribute' => ['supervisor_id' => 'id'],
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->$attribute));
                },
            ],
            [
                ['shipperId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \app\models\CompanyProfile::className(),
                'targetAttribute' => ['shipperId' => 'id'],
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->$attribute));
                },
            ],
            [
                ['shippingId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \app\models\Shipping::className(),
                'targetAttribute' => ['shippingId' => 'id'],
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->$attribute));
                },
            ],
            [
                ['destinationId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \app\models\ContainerPort::className(),
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
        if ($this->newSi == static::NEWSI_YES) {
            $shippingInstruction = new ShippingInstructionForm([
                'number' => $this->shippingInstructionNumber,
                'shipper_id' => $this->shipperId,
                'shipperAddress' => $this->shipperAddress,
                'shipperPhone' => $this->shipperPhone,
                'shipperEmail' => $this->shipperEmail,
                'shipperNpwp' => $this->shipperNpwp,
                'shipping_id' => $this->shippingId,
                'destination_id' => $this->destinationId,
            ]);

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