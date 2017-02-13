<?php

namespace app\controllers;

use yii\filters\VerbFilter;

/**
 * This is the class for controller "TruckSupervisorController".
 */
class TruckSupervisorController extends \app\controllers\base\TruckSupervisorController
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