<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use cornernote\returnurl\ReturnUrl;
use fredyns\suite\filters\AdminLTELayout;
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
            'layout' => [
                'class' => AdminLTELayout::className(),
            ],
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
        $model = new JobContainerForm([
            'newSi' => JobContainerForm::NEWSI_YES,
        ]);
        $actionControl = JobContainerActControl::checkAccess('create', $model);

        try {
            if ($model->load($_POST) && $model->save()) {
                Yii::$app->getSession()->addFlash('success', "Container '{$model->containerNumber}' successfully saved!");

                if (isset($_POST['nextAction']) && $_POST['nextAction'] === 'more') {
                    return $this->redirect([
                            'create',
                            'JobContainerForm' => [
                                'newSi' => JobContainerForm::NEWSI_NO,
                                'shippingInstruction_id' => $model->shippingInstruction_id,
                                'shipperId' => $model->shipperId,
                                'shippingId' => $model->shippingId,
                                'destinationId' => $model->destinationId,
                                'size' => $model->size,
                                'type_id' => $model->type_id,
                                'stuffingDate' => $model->stuffingDate,
                                'containerDepo_id' => $model->containerDepo_id,
                                'stuffingLocation_id' => $model->stuffingLocation_id,
                                'supervisor_id' => $model->supervisor_id,
                                'truckVendor_id' => $model->truckVendor_id,
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