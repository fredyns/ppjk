<?php

namespace app\behaviors;

use Yii;
use yii\base\Event;
use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;
use app\models\form\JobContainerForm;
use app\models\form\ShippingInstructionForm;

/**
 * handling shipping instruction property
 * will create or update depend on some scenario
 *
 * @property JobContainerForm $owner Job Container form
 *
 * @author fredyns
 */
class SIBehavior extends AttributeBehavior
{
    public $siAttribute = 'shippingInstruction_id';
    public $value;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => $this->siAttribute,
                BaseActiveRecord::EVENT_BEFORE_UPDATE => $this->siAttribute,
            ];
        }
    }

    /**
     * Evaluates the value of the user.
     * The return result of this method will be assigned to the current attribute(s).
     * @param Event $event
     * @return mixed the value of the user.
     */
    protected function getValue($event)
    {
        $attribute = $this->siAttribute;
        $value = $this->owner->$attribute;
        $model = null;
        $shippingInstruction_id = $this->owner->getOldAttribute($attribute);

        if (is_numeric($value)) {
            return $value;
        } else if (empty($value)) {
            return NULL;
        } else {
            if ($this->owner->isNewRecord == FALSE && $shippingInstruction_id > 0) {
                $model = ShippingInstructionForm::findOne($shippingInstruction_id);
            }

            if (empty($model)) {
                $model = new ShippingInstructionForm([
                    'recordStatus' => ShippingInstructionForm::RECORDSTATUS_ACTIVE,
                ]);
            }

            $model->copy($this->owner, $this->mirrorAttributes());

            return $model->save(FALSE) ? $model->id : NULL;
        }
    }

    /**
     * @return string[]
     */
    public function mirrorAttributes()
    {
        return [
            'number' => 'shippingInstruction_id',
            'shipper_id' => 'shipperId',
            'shipperAddress' => 'shipperAddress',
            'shipperPhone' => 'shipperPhone',
            'shipperEmail' => 'shipperEmail',
            'shipperNpwp' => 'shipperNpwp',
            'shipping_id' => 'shippingId',
            'destination_id' => 'destinationId',
        ];
    }
}