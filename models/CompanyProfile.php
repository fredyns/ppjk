<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\traits\ModelTool;
use fredyns\suite\traits\ModelBlame;
use fredyns\suite\traits\ModelSoftDelete;
use app\models\base\CompanyProfile as BaseCompanyProfile;

/**
 * This is the model class for table "companyProfile".
 */
class CompanyProfile extends BaseCompanyProfile
{

    use ModelTool,
        ModelBlame,
        ModelSoftDelete;
    const SELFCOMPANY = 1;
    const TYPE_SHIPPER = 1;
    const TYPE_SHIPPING = 2;
    const TYPE_TRUCKVENDOR = 3;
    const TYPE_DEPO = 4;

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
}