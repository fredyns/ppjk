<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\filters\VerbFilter;
use fredyns\suite\filters\AdminLTELayout;
use fredyns\suite\helpers\ViewHelper;
use app\models\form\ContactForm;
use app\models\JobContainer;
use app\models\search\JobContainerPublicSearch;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;

class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            'layout' => [
                'class' => AdminLTELayout::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $publicPage = 'page/home';
        $userPage = 'page/chart';
        $view = Yii::$app->user->isGuest ? $publicPage : $userPage;

        return $this->render($view);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        return $this->redirect(['/user/security/login']);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        return $this->redirect(['/user/security/logout']);
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
                'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Displays page.
     *
     * @return string
     */
    public function actionPage($slug = 'services')
    {
        $view = 'page/'.$slug;

        if (empty($slug) OR is_string($slug) == FALSE OR ViewHelper::exist($view, $this) == FALSE) {
            throw new HttpException(404, 'The requested page does not exist.');
        }

        return $this->render($view);
    }

    /**
     * search container number
     *
     * @return mixed
     */
    public function actionSearch()
    {
        $id = Yii::$app->request->get('id');
        $number = Yii::$app->request->get('number');
        $shipper = (string) Yii::$app->request->get('shipper');

        $number = strtoupper($number);
        //$containerList = str_replace(', ', ',', $containerList);
        //$containerList = str_replace(' ', ',', $containerList);
        //$containerList = str_replace(chr(13), ',', $containerList);
        //$containerNumbers = explode(',', $containerList);
        //$containerNumbers = array_filter($containerNumbers);
        //$searchTerm = implode(', ', $containerNumbers);
        $criteria = ['deliveryOrder' => $number];

        if ($id > 0) {
            $criteria['id'] = $id;
        }

        $query = JobContainer::find()
            ->andWhere($criteria)
        ;

        if (strlen($shipper) > 2) {
            $query->andFilterWhere(['like', 'name', $shipper]);
        }

        return $this->render('search', [
                'searchTerm' => $number,
                'containers' => $query->all(),
        ]);
    }

    /**
     * Lists all active JobContainer models.
     * @return mixed
     */
    public function actionCari()
    {
        $searchModel = new JobContainerPublicSearch;
        $dataProvider = $searchModel->searchIndex($_GET);

        Tabs::clearLocalStorage();
        Url::remember();

        return $this->render('cari', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
        ]);
    }

}