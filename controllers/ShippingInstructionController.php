<?php

namespace app\controllers;

use yii\filters\VerbFilter;

/**
 * This is the class for controller "ShippingInstructionController".
 */
class ShippingInstructionController extends \app\controllers\base\ShippingInstructionController
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