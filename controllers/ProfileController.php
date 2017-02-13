<?php

namespace app\controllers;

use yii\filters\VerbFilter;

/**
 * This is the class for controller "ProfileController".
 */
class ProfileController extends \app\controllers\base\ProfileController
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