<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\traits\ModelTool;
use fredyns\suite\traits\ModelBlame;
use fredyns\suite\traits\ModelSoftDelete;
use app\models\base\CompanyType as BaseCompanyType;

/**
 * This is the model class for table "companyType".
 */
class CompanyType extends BaseCompanyType
{

    use ModelTool,
        ModelBlame,
        ModelSoftDelete;
    public static $usedBySystem = [
        1 => 'Shipper Clasification',
        2 => 'Shipping Clasification',
        3 => 'Truck Vendor Clasification',
        4 => 'Container Depo Clasification',
    ];

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
        return ArrayHelper::merge(
                parent::rules(), [
                # custom validation rules
                ]
        );
    }

    /**
     * provide data options from model
     *
     * @return array
     */
    public static function options()
    {
        return ArrayHelper::map(static::findAll(['recordStatus' => 'active']), 'id', 'name');
    }

    /**
     * @inheritdoc
     */
    public function getCompanyProfiles()
    {
        return parent::getCompanyProfiles()
                ->andWhere(['recordStatus' => JobContainer::RECORDSTATUS_ACTIVE]);
    }
}