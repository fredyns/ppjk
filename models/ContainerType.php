<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\traits\ModelTool;
use fredyns\suite\traits\ModelBlame;
use fredyns\suite\traits\ModelSoftDelete;
use app\models\base\ContainerType as BaseContainerType;

/**
 * This is the model class for table "containerType".
 */
class ContainerType extends BaseContainerType
{

    use ModelTool,
        ModelBlame;

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
     * provide data options from model
     *
     * @return array
     */
    public static function options()
    {
        return ArrayHelper::map(static::find()->all(), 'id', 'name');
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