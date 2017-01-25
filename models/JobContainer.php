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
 */
class JobContainer extends BaseJobContainer
{

    use ModelTool, ModelBlame, ModelSoftDelete;
    
    const ALIAS_DRIVER = 'driver';
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
    public function getDriver()
    {
        return parent::getDriver()->alias(static::ALIAS_DRIVER);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupervisor()
    {
        return parent::getSupervisor()->alias(static::ALIAS_SUPERVISOR);
    }
}
