<?php

namespace app\controllers;

use yii\filters\VerbFilter;

/**
 * This is the class for controller "PersonelController".
 */
class PersonelController extends \app\controllers\base\PersonelController
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