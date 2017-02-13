<?php

namespace app\controllers;

use yii\filters\VerbFilter;

/**
 * This is the class for controller "StuffingLocationController".
 */
class StuffingLocationController extends \app\controllers\base\StuffingLocationController
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