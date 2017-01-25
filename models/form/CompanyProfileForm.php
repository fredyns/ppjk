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
          [['address', 'recordStatus'], 'string'],
          [['deleted_at', 'deleted_by'], 'integer'],
          [['name', 'phone'], 'string', 'max' => 255],
          [['email'], 'string', 'max' => 64],
          [['npwp'], 'string', 'max' => 32],
          ['recordStatus', 'in', 'range' => [
                    self::RECORDSTATUS_ACTIVE,
                    self::RECORDSTATUS_DELETED,
                ]
            ],
        ];
    }

}
