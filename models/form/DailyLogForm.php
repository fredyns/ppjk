<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\helpers\StringHelper;
use app\models\DailyLog;

/**
 * This is the form model class for table "daily_log".
 */
class DailyLogForm extends DailyLog
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
          [['date'], 'required'],
          [['date'], 'safe'],
          [['containerQty'], 'integer'],
        ];
    }

}
