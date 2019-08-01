<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\traits\ModelTool;
use fredyns\suite\traits\ModelBlame;
use fredyns\suite\traits\ModelSoftDelete;
use app\models\base\MonthlyDestination as BaseMonthlyDestination;

/**
 * This is the model class for table "monthly_destination".
 */
class MonthlyDestination extends BaseMonthlyDestination
{

    use ModelTool, ModelBlame;
    
    const ALIAS_DESTINATION = 'destination';

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
    public function getDestination()
    {
        return parent::getDestination()->alias(static::ALIAS_DESTINATION);
    }
}
