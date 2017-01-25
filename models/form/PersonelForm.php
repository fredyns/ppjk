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
          [['companyProfile_id', 'profile_id'], 'required'],
          [['companyProfile_id', 'profile_id', 'deleted_at', 'deleted_by'], 'integer'],
          [['recordStatus'], 'string'],
          [['title'], 'string', 'max' => 64],
          [['companyProfile_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\CompanyProfile::className(), 'targetAttribute' => ['companyProfile_id' => 'id']],
          [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
          ['recordStatus', 'in', 'range' => [
                    self::RECORDSTATUS_ACTIVE,
                    self::RECORDSTATUS_DELETED,
                ]
            ],
        ];
    }

}
