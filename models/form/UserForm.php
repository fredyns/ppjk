<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\helpers\StringHelper;
use app\models\User;

/**
 * This is the form model class for table "user".
 */
class UserForm extends User
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
          [['username', 'email', 'password_hash', 'auth_key'], 'required'],
          [['confirmed_at', 'blocked_at', 'flags'], 'integer'],
          [['username', 'email', 'unconfirmed_email'], 'string', 'max' => 255],
          [['password_hash'], 'string', 'max' => 60],
          [['auth_key'], 'string', 'max' => 32],
          [['registration_ip'], 'string', 'max' => 45],
          [['email'], 'unique'],
          [['username'], 'unique'],
        ];
    }

}
