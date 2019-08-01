<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\traits\ModelTool;
use fredyns\suite\traits\ModelBlame;
use fredyns\suite\traits\ModelSoftDelete;
use app\models\base\MonthlyDriving as BaseMonthlyDriving;

/**
 * This is the model class for table "monthly_driving".
 */
class MonthlyDriving extends BaseMonthlyDriving
{

    use ModelTool, ModelBlame;
    
    const ALIAS_DRIVER = 'driver';

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
    public function getDriver()
    {
        return parent::getDriver()->alias(static::ALIAS_DRIVER);
    }
}
