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
                ['bio', 'name', 'public_email', 'gravatar_email', 'location', 'website', 'timezone'],
                'filter',
                'filter' => function($value) {

                    return StringHelper::plaintextFilter($value);
                },
            ],
            /* default value */
            /* required */
            /* safe */
            /* field type */
            [['user_id', 'picture_id'], 'integer'],
            [['bio'], 'string'],
            [['name', 'public_email', 'gravatar_email', 'location', 'website'], 'string', 'max' => 255],
            [['timezone'], 'string', 'max' => 40],
            /* value limitation */
            [['user_id'], 'unique'],
            /* value references */
            [
                ['picture_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \app\models\UploadedFile::className(),
                'targetAttribute' => ['picture_id' => 'id'],
            ],
            [
                ['user_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \app\models\User::className(),
                'targetAttribute' => ['user_id' => 'id'],
            ],
        ];
    }
}