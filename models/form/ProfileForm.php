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
        return [
          /* filter */
          /* default value */
          /* required */
          /* safe */
          /* field type */
          /* value limitation */
          /* value references */
          [['user_id', 'picture_id'], 'integer'],
          [['bio'], 'string'],
          [['name', 'public_email', 'gravatar_email', 'location', 'website'], 'string', 'max' => 255],
          [['gravatar_id'], 'string', 'max' => 32],
          [['timezone'], 'string', 'max' => 40],
          [['user_id'], 'unique'],
          [['picture_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\UploadedFile::className(), 'targetAttribute' => ['picture_id' => 'id']],
          [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

}
