<?php

namespace app\controllers;

use yii\filters\VerbFilter;

/**
 * This is the class for controller "ContainerPortController".
 */
class ContainerPortController extends \app\controllers\base\ContainerPortController
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