<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\helpers\StringHelper;
use app\models\Profile;

/**
 * This is the form model class for table "profile".
 */
class ProfileForm extends Profile
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
                ['bio', 'name', 'public_email', 'gravatar_email', 'location', 'website', 'timezone', 'phone', 'address'],
                'filter',
                'filter' => function($value) {

                    return StringHelper::plaintextFilter($value);
                },
            ],
            /* default value */
            ['recordStatus', 'default', 'value' => static::RECORDSTATUS_ACTIVE],
            /* required */
            [['name'], 'required'],
            /* safe */
            /* field type */
            [['user_id'], 'integer'],
            [['bio', 'address', 'recordStatus'], 'string'],
            [['name', 'public_email', 'gravatar_email', 'location', 'website'], 'string', 'max' => 255],
            [['gravatar_id'], 'string', 'max' => 32],
            [['timezone'], 'string', 'max' => 40],
            [['phone'], 'string', 'max' => 64],
            /* value limitation */
            [['user_id'], 'unique'],
            ['recordStatus', 'in', 'range' => [
                    self::RECORDSTATUS_ACTIVE,
                    self::RECORDSTATUS_DELETED,
                ]
            ],
            ['timezone', 'in', 'range' => \DateTimeZone::listIdentifiers()],
            /* value references */
            [
                ['user_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \app\models\User::className(),
                'targetAttribute' => ['user_id' => 'id'],
            ],
            /* upload */
            [
                'picture',
                'file',
                'extensions' => ['jpg', 'png'],
                'maxSize' => 4096000,
            ],
        ];
    }
}