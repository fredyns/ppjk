<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\helpers\StringHelper;
use app\models\ContainerType;

/**
 * This is the form model class for table "containerType".
 */
class ContainerTypeForm extends ContainerType
{

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
        return [
            /* filter */
            [
                ['name'],
                'filter',
                'filter' => function($value) {

                    return StringHelper::plaintextFilter($value);
                },
            ],
            /* default value */

            /* required */
            [['name'], 'required'],
            /* safe */
            /* field type */
            [['name'], 'string', 'max' => 64],
            /* value limitation */
            /* value references */
        ];
    }
}