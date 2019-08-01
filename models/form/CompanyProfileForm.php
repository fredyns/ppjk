<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\helpers\StringHelper;
use app\models\CompanyProfile;

/**
 * This is the form model class for table "companyProfile".
 */
class CompanyProfileForm extends CompanyProfile
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
                ['name', 'address', 'phone', 'npwp'],
                'filter',
                'filter' => function($value) {

                    return StringHelper::plaintextFilter($value);
                },
            ],
            /* default value */
            ['recordStatus', 'default', 'value' => static::RECORDSTATUS_ACTIVE],
            /* required */
            [['name', 'address'], 'required'],
            /* safe */
            /* field type */
            [['companyType_id'], 'integer'],
            [['address', 'recordStatus'], 'string'],
            [['name', 'phone'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 64],
            [['npwp'], 'string', 'max' => 32],
            /* value limitation */
            [['email'], 'email'],
            ['recordStatus', 'in', 'range' => [
                    self::RECORDSTATUS_ACTIVE,
                    self::RECORDSTATUS_DELETED,
                ]
            ],
            /* value references */
            [
                ['companyType_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \app\models\CompanyType::className(),
                'targetAttribute' => ['companyType_id' => 'id'],
            ],
        ];
    }
}