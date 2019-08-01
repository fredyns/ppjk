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
 *
 * @property boolean $showSiServices
 * @property boolean $showSiOrders
 * @property boolean $showContainerServices
 * @property boolean $showTruckServices
 *
 * @property ShippingInstruction[] $siServices
 * @property ShippingInstruction[] $siOrders
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

    /**
     * @inheritdoc
     */
    public function getPersonels()
    {
        return parent::getPersonels()
                ->andWhere(['recordStatus' => Personel::RECORDSTATUS_ACTIVE]);
    }

    /**
     * get all SI services by shipping company
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSiServices()
    {
        return $this
                ->hasMany(ShippingInstruction::className(), ['shipping_id' => 'id'])
                ->andWhere(['recordStatus' => ShippingInstruction::RECORDSTATUS_ACTIVE]);
    }

    /**
     * get all SI orders by shipper company
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSiOrders()
    {
        return $this
                ->hasMany(ShippingInstruction::className(), ['shipper_id' => 'id'])
                ->andWhere(['recordStatus' => ShippingInstruction::RECORDSTATUS_ACTIVE]);
    }

    /**
     * get all container services by depo company
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContainerServices()
    {
        return $this
                ->hasMany(JobContainer::className(), ['containerDepo_id' => 'id'])
                ->andWhere(['recordStatus' => JobContainer::RECORDSTATUS_ACTIVE]);
    }

    /**
     * get all truck services by truck vendor
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTruckServices()
    {
        return $this
                ->hasMany(JobContainer::className(), ['truckVendor_id' => 'id'])
                ->andWhere(['recordStatus' => JobContainer::RECORDSTATUS_ACTIVE]);
    }

    /**
     * check whether it's necessary to show SI services
     *
     * @return boolean
     */
    public function getShowSiServices()
    {
        return ($this->companyType_id == static::TYPE_SHIPPING OR $this->getSiServices()->count() > 0);
    }

    /**
     * check whether it's necessary to show SI services
     *
     * @return boolean
     */
    public function getShowSiOrders()
    {
        return ($this->companyType_id == static::TYPE_SHIPPER OR $this->getSiOrders()->count() > 0);
    }

    /**
     * check whether it's necessary to show container services
     *
     * @return boolean
     */
    public function getShowContainerServices()
    {
        return ($this->companyType_id == static::TYPE_DEPO OR $this->getContainerServices()->count() > 0);
    }

    /**
     * check whether it's necessary to show truck services
     *
     * @return boolean
     */
    public function getShowTruckServices()
    {
        return ($this->companyType_id == static::TYPE_TRUCKVENDOR OR $this->getTruckServices()->count() > 0);
    }
}