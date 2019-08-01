<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\behaviors\BelongingModelBehavior;
use fredyns\suite\helpers\StringHelper;
use app\models\CompanyProfile;
use app\models\Personel;
use app\models\Profile;

/**
 * This is the form model class for table "personel".
 */
class PersonelForm extends Personel
{
    public $companyAddress;
    public $companyPhone;
    public $companyEmail;
    public $profilePhone;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(
                parent::behaviors(),
                [
                # custom behaviors
                [
                    'class' => BelongingModelBehavior::className(),
                    'modelClass' => CompanyProfile::className(),
                    'relatedAttribute' => 'companyProfile_id',
                    'valueAttribute' => 'name',
                    'otherAttributes' => [
                        'address' => 'companyAddress',
                        'phone' => 'companyPhone',
                        'email' => 'companyEmail',
                    ],
                ],
                [
                    'class' => BelongingModelBehavior::className(),
                    'modelClass' => Profile::className(),
                    'relatedAttribute' => 'profile_id',
                    'valueAttribute' => 'name',
                    'otherAttributes' => [
                        'phone' => 'profilePhone',
                    ],
                ],
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
                [
                    // personel
                    'title',
                    // company
                    'companyAddress',
                    'companyPhone',
                    'companyEmail',
                    // profile
                    'profilePhone',
                ],
                'filter',
                'filter' => function($value) {

                    return StringHelper::plaintextFilter($value);
                },
            ],
            /* default value */
            ['recordStatus', 'default', 'value' => static::RECORDSTATUS_ACTIVE],
            /* required */
            [['companyProfile_id', 'profile_id'], 'required'],
            [
                ['companyAddress', 'companyPhone'],
                'required',
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->companyProfile_id) == FALSE);
                },
                'whenClient' => '
                    function (attribute, value) {
                        companyInput = $(\'#'.$this->formName().'-companyProfile_id\').val();

                        return (companyInput && isNaN(companyInput));
                    }',
            ],
            /* safe */
            /* field type */
            [['recordStatus'], 'string'],
            [['title'], 'string', 'max' => 64],
            [
                ['companyProfile_id', 'profile_id'],
                'string',
                'max' => 255,
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->$attribute) == FALSE);
                },
            ],
            [['companyAddress'], 'string'],
            [['companyPhone'], 'string', 'max' => 255],
            [['companyEmail', 'profilePhone'], 'string', 'max' => 64],
            /* value limitation */
            ['recordStatus', 'in', 'range' => [
                    self::RECORDSTATUS_ACTIVE,
                    self::RECORDSTATUS_DELETED,
                ]
            ],
            [['companyEmail'], 'email'],
            /* value references */
            [
                ['companyProfile_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \app\models\CompanyProfile::className(),
                'targetAttribute' => ['companyProfile_id' => 'id'],
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->$attribute));
                },
            ],
            [
                ['profile_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \app\models\Profile::className(),
                'targetAttribute' => ['profile_id' => 'id'],
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->$attribute));
                },
            ],
        ];
    }
}