<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\traits\ModelTool;
use fredyns\suite\traits\ModelBlame;
use fredyns\suite\traits\ModelSoftDelete;
use app\models\base\TruckSupervisor as BaseTruckSupervisor;

/**
 * This is the model class for table "truckSupervisor".
 */
class TruckSupervisor extends BaseTruckSupervisor
{

    use ModelTool,
        ModelBlame,
        ModelSoftDelete;

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
    public function getJobContainers()
    {
        return parent::getJobContainers()
                ->andWhere(['recordStatus' => JobContainer::RECORDSTATUS_ACTIVE]);
    }
}