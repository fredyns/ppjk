<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base-model class for table "companyType".
 *
 * @property integer $id
 * @property string $name
 * @property string $recordStatus
 * @property integer $deleted_at
 * @property integer $deleted_by
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property \app\models\CompanyProfile[] $companyProfiles
 * @property string $aliasModel
 */
abstract class CompanyType extends \yii\db\ActiveRecord
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
        return 'companyType';
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
            [['name'], 'required'],
            [['recordStatus'], 'string'],
            [['deleted_at', 'deleted_by'], 'integer'],
            [['name'], 'string', 'max' => 32],
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
            'name' => 'Name',
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
    public function getCompanyProfiles()
    {
        return $this->hasMany(\app\models\CompanyProfile::className(), ['companyType_id' => 'id']);
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
