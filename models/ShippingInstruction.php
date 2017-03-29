<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\traits\ModelTool;
use fredyns\suite\traits\ModelBlame;
use fredyns\suite\traits\ModelSoftDelete;
use app\models\base\ShippingInstruction as BaseShippingInstruction;

/**
 * This is the model class for table "shippingInstruction".
 */
class ShippingInstruction extends BaseShippingInstruction
{

    use ModelTool,
        ModelBlame,
        ModelSoftDelete;
    const NUMBERMASK = '9999 aa a{2,5}';
    const ALIAS_SHIPPER = 'shipper';
    const ALIAS_SHIPPING = 'shipping';
    const ALIAS_DESTINATION = 'destination';

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
}