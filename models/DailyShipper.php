<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\traits\ModelTool;
use fredyns\suite\traits\ModelBlame;
use fredyns\suite\traits\ModelSoftDelete;
use app\models\base\DailyShipper as BaseDailyShipper;

/**
 * This is the model class for table "daily_shipper".
 */
class DailyShipper extends BaseDailyShipper
{

    use ModelTool, ModelBlame;
    
    const ALIAS_SHIPPER = 'shipper';

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
        return ArrayHelper::merge(
             parent::rules(),
             [
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
}
