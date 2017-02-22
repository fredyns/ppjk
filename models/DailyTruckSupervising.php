<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\traits\ModelTool;
use fredyns\suite\traits\ModelBlame;
use fredyns\suite\traits\ModelSoftDelete;
use app\models\base\DailyTruckSupervising as BaseDailyTruckSupervising;

/**
 * This is the model class for table "daily_truckSupervising".
 */
class DailyTruckSupervising extends BaseDailyTruckSupervising
{

    use ModelTool, ModelBlame;
    
    const ALIAS_SUPERVISOR = 'supervisor';

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
    public function getSupervisor()
    {
        return parent::getSupervisor()->alias(static::ALIAS_SUPERVISOR);
    }
}
