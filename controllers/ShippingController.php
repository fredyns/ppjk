<?php

namespace app\controllers;

use yii\filters\VerbFilter;

/**
 * This is the class for controller "ShippingController".
 */
class ShippingController extends \app\controllers\base\ShippingController
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
}