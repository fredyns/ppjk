<?php

namespace app\controllers;

use yii\filters\VerbFilter;

/**
 * This is the class for controller "CompanyProfileController".
 */
class CompanyProfileController extends \app\controllers\base\CompanyProfileController
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