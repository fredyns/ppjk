<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\traits\ModelTool;
use fredyns\suite\traits\ModelBlame;
use fredyns\suite\traits\ModelSoftDelete;
use app\models\base\JobContainer as BaseJobContainer;

/**
 * This is the model class for table "jobContainer".
 *
 * @property string $sizeLabel label for size value
 * @property string $typeName label for type value
 */
class JobContainer extends BaseJobContainer
{
    use ModelTool,
        ModelBlame,
        ModelSoftDelete;
    const ALIAS_TYPE = 'type';
    const ALIAS_CONTAINERDEPO = 'containerDepo';
    const ALIAS_SUPERVISOR = 'supervisor';
    const ALIAS_TRUCKVENDOR = 'truckVendor';
    const ALIAS_SHIPPER = 'shipper';
    const ALIAS_SHIPPING = 'shipping';
    const ALIAS_DESTINATION = 'destination';
    const DOMASK = '9999 aa a{2,5}';
    const DOPATTERN = '/^[0-9]+ [a-zA-Z]+ [a-zA-Z]+$/';
    const CONTAINERNUMBERMASK = 'aaaa 9999999';
    const SIZE_20 = '20';
    const SIZE_40 = '40';
    const SIZE_45 = '45';
    const SIZE_LCL = 'lcl';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(
                parent::behaviors(), [
                # custom behaviors
                ]
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(
                parent::rules(), [
                # custom validation rules
                ]
        );
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(
                parent::attributeLabels(),
                [
                'shippingInstruction_id' => 'No SI',
                'containerDepo_id' => 'Depo',
                'supervisor_id' => 'Mandor',
                'policenumber' => 'Police Number',
                ]
        );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShipper()
    {
        return parent::getShipper()->alias(static::ALIAS_SHIPPER);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShipping()
    {
        return parent::getShipping()->alias(static::ALIAS_SHIPPING);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestination()
    {
        return parent::getDestination()->alias(static::ALIAS_DESTINATION);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return parent::getType()->alias(static::ALIAS_TYPE);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContainerDepo()
    {
        return parent::getContainerDepo()->alias(static::ALIAS_CONTAINERDEPO);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupervisor()
    {
        return parent::getSupervisor()->alias(static::ALIAS_SUPERVISOR);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTruckVendor()
    {
        return parent::getTruckVendor()->alias(static::ALIAS_TRUCKVENDOR);
    }

    /**
     * get column recordStatus enum value label
     * @param string $value
     * @return string
     */
    public static function getSizeValueLabel($value)
    {
        $labels = self::optsSize();

        if (isset($labels[$value])) {
            return $labels[$value];
        }

        return $value;
    }

    /**
     * column recordStatus ENUM value labels
     * @return array
     */
    public static function optsSize()
    {
        return [
            self::SIZE_LCL => "LCL",
            self::SIZE_20 => "20'",
            self::SIZE_40 => "40'",
            self::SIZE_45 => "45'",
        ];
    }

    /**
     * @return string label for size value
     */
    public function getSizeLabel()
    {
        return static::getSizeValueLabel($this->size);
    }

    /**
     * @return string label for size value
     */
    public function getTypeName()
    {
        return $this->subAttribute('type.name');
    }

}