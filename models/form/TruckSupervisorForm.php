<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\helpers\StringHelper;
use app\models\TruckSupervisor;

/**
 * This is the form model class for table "truckSupervisor".
 */
class TruckSupervisorForm extends TruckSupervisor
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
            ['recordStatus', 'default', 'value' => static::RECORDSTATUS_ACTIVE],
            /* required */
            /* safe */
            [['name'], 'required'],
            /* field type */
            [['recordStatus'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 64],
            /* value limitation */
            ['recordStatus', 'in', 'range' => [
                    self::RECORDSTATUS_ACTIVE,
                    self::RECORDSTATUS_DELETED,
                ]
            ],
            /* value references */
        ];
    }
}