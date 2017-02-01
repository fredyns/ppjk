<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use fredyns\suite\helpers\StringHelper;
use fredyns\suite\models\Profile as BaseProfile;

/**
 * This is the model class for table "profile".
 *
 * @property mixed $picture
 * @property integer $picture_id
 * @property string $phone
 * @property string $address
 * @property string $recordStatus
 * @property integer $deleted_at
 * @property integer $deleted_by
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property \app\models\JobContainer[] $jobContainers
 * @property \app\models\Personel[] $personels
 */
class Profile extends BaseProfile
{
    /**
     * ENUM field values
     */
    const RECORDSTATUS_ACTIVE = 'active';
    const RECORDSTATUS_DELETED = 'deleted';

    var $enum_labels = false;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(
                parent::behaviors(),
                [
                # custom behaviors
                'blameable' => [
                    'class' => BlameableBehavior::className(),
                ],
                'timestamp' => [
                    'class' => TimestampBehavior::className(),
                ],
                ]
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(
                parent::rules(),
                [
                # custom validation rules
                'textFilter' => [
                    ['phone', 'address'],
                    'filter',
                    'filter' => function ($value) {
                        return StringHelper::plaintextFilter($value);
                    },
                ],
                'phoneMax' => [['phone'], 'string', 'max' => 64],
                ]
        );
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User',
            'name' => 'Name',
            'public_email' => 'Public Email',
            'gravatar_email' => 'Gravatar Email',
            'gravatar_id' => 'Gravatar',
            'location' => 'Location',
            'website' => 'Website',
            'bio' => 'Bio',
            'timezone' => 'Timezone',
            'picture_id' => 'Picture',
            'phone' => 'Phone',
            'address' => 'Address',
            'recordStatus' => 'Record Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobContainers()
    {
        return $this->hasMany(\app\models\JobContainer::className(), ['driver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonels()
    {
        return $this->hasMany(\app\models\Personel::className(), ['profile_id' => 'id']);
    }

    /**
     * get column recordStatus enum value label
     * @param string $value
     * @return string
     */
    public static function getRecordStatusValueLabel($value)
    {
        $labels = self::optsRecordStatus();

        if (isset($labels[$value])) {
            return $labels[$value];
        }

        return $value;
    }

    /**
     * column recordStatus ENUM value labels
     * @return array
     */
    public static function optsRecordStatus()
    {
        return [
            self::RECORDSTATUS_ACTIVE => self::RECORDSTATUS_ACTIVE,
            self::RECORDSTATUS_DELETED => self::RECORDSTATUS_DELETED,
        ];
    }
}