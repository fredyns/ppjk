<?php

namespace app\behaviors;

use Yii;
use yii\base\Event;
use yii\helpers\ArrayHelper;
use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;
use app\models\CompanyProfile;
use app\models\Personel;
use app\models\Profile;

/**
 * handling Customer property
 * when typing a name instead of selecting, it will be inserted as new Customer
 *
 * @property string $userAttribute
 * @property string $customerAttribute
 * @property string $customerAddressAttribute
 * @property string $customerPhoneAttribute
 *
 * @author fredy
 */
class DriverBehavior extends AttributeBehavior
{
    public $driverAttribute = 'driver_id';
    public $driverPhoneAttribute = 'driverPhone';
    public $driverTitle = 'Sopir';
    public $value;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => $this->driverAttribute,
                BaseActiveRecord::EVENT_BEFORE_UPDATE => $this->driverAttribute,
            ];
        }
    }

    /**
     * Evaluates the value of the user.
     * The return result of this method will be assigned to the current attribute(s).
     * @param Event $event
     * @return mixed the value of the user.
     */
    protected function getValue($event)
    {
        $value = ArrayHelper::getValue($this->owner, $this->driverAttribute);

        if (is_numeric($value)) {
            return $value;
        } elseif (empty($value)) {
            return NULL;
        } else {
            $profile = new Profile([
                'name' => $value,
                'phone' => ArrayHelper::getValue($this->owner, $this->driverPhoneAttribute),
            ]);

            if ($profile->save(FALSE)) {
                $personel = new Personel([
                    'companyProfile_id' => CompanyProfile::SELFCOMPANY,
                    'profile_id' => $profile->id,
                    'title' => $this->driverTitle,
                ]);

                if ($personel->save(FALSE)) {
                    return $profile->id;
                }
            }

            return NULL;
        }
    }
}