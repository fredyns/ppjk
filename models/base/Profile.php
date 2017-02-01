<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base-model class for table "profile".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $public_email
 * @property string $gravatar_email
 * @property string $gravatar_id
 * @property string $location
 * @property string $website
 * @property string $bio
 * @property string $timezone
 * @property string $picture_id
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
 * @property \app\models\UploadedFile $picture
 * @property \app\models\User $user
 * @property string $aliasModel
 */
abstract class Profile extends \yii\db\ActiveRecord
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
    public static function tableName()
    {
        return 'profile';
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'blameable' => [
                'class' => BlameableBehavior::className(),
            ],
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'picture_id', 'deleted_at', 'deleted_by'], 'integer'],
            [['bio', 'address', 'recordStatus'], 'string'],
            [['name', 'public_email', 'gravatar_email', 'location', 'website'], 'string', 'max' => 255],
            [['gravatar_id'], 'string', 'max' => 32],
            [['timezone'], 'string', 'max' => 40],
            [['phone'], 'string', 'max' => 64],
            [['user_id'], 'unique'],
            [['picture_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\UploadedFile::className(), 'targetAttribute' => ['picture_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\User::className(), 'targetAttribute' => ['user_id' => 'id']],
            ['recordStatus', 'in', 'range' => [
                    self::RECORDSTATUS_ACTIVE,
                    self::RECORDSTATUS_DELETED,
                ]
            ]
        ];
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
     * @return \yii\db\ActiveQuery
     */
    public function getPicture()
    {
        return $this->hasOne(\app\models\UploadedFile::className(), ['id' => 'picture_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'user_id']);
    }
                
    /**
     * get column recordStatus enum value label
     * @param string $value
     * @return string
     */
    public static function getRecordStatusValueLabel($value)
    {
        $labels = self::optsRecordStatus();

        if(isset($labels[$value])) {
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
