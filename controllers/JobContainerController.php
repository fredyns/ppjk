<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use cornernote\returnurl\ReturnUrl;
use app\models\form\JobContainerForm;
use app\actioncontrols\JobContainerActControl;

/**
 * This is the class for controller "JobContainerController".
 */
class JobContainerController extends \app\controllers\base\JobContainerController
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

    /**
     * @inheritdoc
     */
    public function actionCreate()
    {
        $model = new JobContainerForm;
        $actionControl = JobContainerActControl::checkAccess('create', $model);

        try {
            if ($model->load($_POST) && $model->save()) {
                Yii::$app->getSession()->addFlash('success', "Container '{$model->containerNumber}' successfully saved!");

                if (isset($_POST['nextAction']) && $_POST['nextAction'] === 'more') {
                    return $this->redirect([
                            'create',
                            'JobContainerForm' => [
                                'shippingInstruction_id' => $model->shippingInstruction_id,
                            ],
                    ]);
                } else {
                    return $this->redirect(ReturnUrl::getUrl(Url::previous()));
                }
            } elseif (!Yii::$app->request->isPost) {
                $model->load($_GET);
            }
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2])) ? $e->errorInfo[2] : $e->getMessage();
            $model->addError('_exception', $msg);
        }

        return $this->render('create',
                [
                'model' => $model,
                'actionControl' => $actionControl,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function actionUpdate($id)
    {
        $model = $this->findForm($id);
        $actionControl = JobContainerActControl::checkAccess('update', $model);

        if ($model->load($_POST) && $model->save()) {
            Yii::$app->getSession()->addFlash('success', "Data successfully updated!");

            return $this->redirect(ReturnUrl::getUrl(Url::previous()));
        } elseif (!Yii::$app->request->isPost) {
            $model->shipperId = $model->shippingInstruction->shipper_id;
            $model->shippingId = $model->shippingInstruction->shipping_id;
            $model->destinationId = $model->shippingInstruction->destination_id;
        }

        return $this->render('update',
                [
                'model' => $model,
                'actionControl' => $actionControl,
        ]);
    }
}