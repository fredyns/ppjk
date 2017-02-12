<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\controllers\base;

use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use cornernote\returnurl\ReturnUrl;
use app\models\ShippingInstruction;
use app\models\search\ShippingInstructionSearch;
use app\models\form\ShippingInstructionForm;
use app\actioncontrols\ShippingInstructionActControl;

/**
 * ShippingInstructionController implements the CRUD actions for ShippingInstruction model.
 */
class ShippingInstructionController extends Controller
{


    /**
     * @var boolean whether to enable CSRF validation for the actions in this controller.
     * CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
     */
    public $enableCsrfValidation = false;

    
    /**
     * Lists all active ShippingInstruction models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShippingInstructionSearch;
        $dataProvider = $searchModel->searchIndex($_GET);
        $actionControl = ShippingInstructionActControl::checkAccess('index', $searchModel);

        Tabs::clearLocalStorage();
        Url::remember();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'actionControl' => $actionControl,
            'searchModel' => $searchModel,
        ]);
    }

    
    /**
     * Lists deleted active ShippingInstruction models.
     * @return mixed
     */
    public function actionDeleted()
    {
        $searchModel = new ShippingInstructionSearch;
        $dataProvider = $searchModel->searchDeleted($_GET);
        $actionControl = ShippingInstructionActControl::checkAccess('deleted', $searchModel);

        Tabs::clearLocalStorage();
        Url::remember();

        return $this->render('deleted', [
            'dataProvider' => $dataProvider,
            'actionControl' => $actionControl,
            'searchModel' => $searchModel,
        ]);
    }

    
    /**
     * Displays a single ShippingInstruction model.
     * @param integer $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $actionControl = ShippingInstructionActControl::checkAccess('view', $model);

        Url::remember();
        Tabs::rememberActiveState();

        return $this->render('view', [
            'model' => $model,
            'actionControl' => $actionControl,
        ]);
    }

    /**
     * Creates a new ShippingInstruction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ShippingInstructionForm;
        $actionControl = ShippingInstructionActControl::checkAccess('create', $model);

        try {
            if ($model->load($_POST) && $model->save()) {
                Yii::$app->getSession()->addFlash('success', "Data successfully saved!");

                return $this->redirect(ReturnUrl::getUrl(Url::previous()));
            } elseif (!Yii::$app->request->isPost) {
                $model->load($_GET);
            }
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
            $model->addError('_exception', $msg);
        }

        return $this->render('create', [
            'model' => $model,
            'actionControl' => $actionControl,
        ]);
    }

    /**
     * Updates an existing ShippingInstruction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findForm($id);
        $actionControl = ShippingInstructionActControl::checkAccess('update', $model);

        if ($model->load($_POST) && $model->save()) {
            Yii::$app->getSession()->addFlash('success', "Data successfully updated!");

            return $this->redirect(ReturnUrl::getUrl(Url::previous()));
        }

        return $this->render('update',
                [
                'model' => $model,
                'actionControl' => $actionControl,
        ]);
    }

    /**
     * Deletes an existing ShippingInstruction model.
     * If deletion is successful, the browser will be redirected to the previous page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $model = $this->findModel($id);

            ShippingInstructionActControl::checkAccess('delete', $model);

            if ($model->delete() !== false) {
                Yii::$app->getSession()->addFlash('info', "Data successfully deleted!");
            }
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
            Yii::$app->getSession()->addFlash('error', $msg);
        } finally {
            return $this->redirect(ReturnUrl::getUrl(Url::previous()));
        }
    }

    
    /**
     * Restores an deleted ShippingInstruction model.
     * If restoration is successful, the browser will be redirected to the previous page.
     * @param integer $id
     * @return mixed
     */
    public function actionRestore($id)
    {
        try {
            $model = $this->findModel($id);

            ShippingInstructionActControl::checkAccess('restore', $model);

            if ($model->restore() !== false) {
                Yii::$app->getSession()->addFlash('success', "Data successfully restored!");
            }
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
            Yii::$app->getSession()->addFlash('error', $msg);
        } finally {
            return $this->redirect(ReturnUrl::getUrl(Url::previous()));
        }
    }

    
    /**
     * Finds the ShippingInstruction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShippingInstruction the loaded model
     * @throws HttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShippingInstruction::findOne($id)) !== null) {
            return $model;
        } else {
            throw new HttpException(404, 'The requested page does not exist.');
        }
    }

    /**
     * Finds the ShippingInstruction form model for modification.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShippingInstructionForm the loaded model
     * @throws HttpException if the model cannot be found
     */
    protected function findForm($id)
    {
        if (($model = ShippingInstructionForm::findOne($id)) !== null) {
            return $model;
        } else {
            throw new HttpException(404, 'The requested page does not exist.');
        }
    }
}