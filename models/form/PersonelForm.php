<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\helpers\StringHelper;
use app\models\Personel;

/**
 * This is the form model class for table "personel".
 */
class PersonelForm extends Personel
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
                ['title'],
                'filter',
                'filter' => function($value) {

                    return StringHelper::plaintextFilter($value);
                },
            ],
            /* default value */
            ['recordStatus', 'default', 'value' => static::RECORDSTATUS_ACTIVE],
            /* required */
            [['companyProfile_id', 'profile_id'], 'required'],
            /* safe */
            /* field type */
            [['companyProfile_id', 'profile_id'], 'integer'],
            [['recordStatus'], 'string'],
            [['title'], 'string', 'max' => 64],
            /* value limitation */
            ['recordStatus', 'in', 'range' => [
                    self::RECORDSTATUS_ACTIVE,
                    self::RECORDSTATUS_DELETED,
                ]
            ],
            /* value references */
            [
                ['companyProfile_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \app\models\CompanyProfile::className(),
                'targetAttribute' => ['companyProfile_id' => 'id'],
            ],
            [
                ['profile_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \app\models\Profile::className(),
                'targetAttribute' => ['profile_id' => 'id'],
            ],
        ];
    }
}