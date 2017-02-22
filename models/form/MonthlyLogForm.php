<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\helpers\StringHelper;
use app\models\MonthlyLog;

/**
 * This is the form model class for table "monthly_log".
 */
class MonthlyLogForm extends MonthlyLog
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
          [['month'], 'required'],
          [['month'], 'safe'],
          [['containerQty'], 'integer'],
        ];
    }

}
