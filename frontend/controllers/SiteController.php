<?php
namespace frontend\controllers;

use app\models\HelpdeskSearch;
use app\models\Personnel;
// use app\models\Shifts;
use app\models\SotrudForm;
use app\models\TodoistSearch;
use app\models\User;
use app\models\Zakaz;
use app\models\ZakazSearch;
use app\models\AnalyticsList; 
use DateTime;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
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
                'only' => ['index', 'logout', 'signup','admin','analytics'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['logout', 'setting', 'login', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['manager'],
                        'allow' => true,
                        'roles' => ['manager'],
                    ],
                    [
                        'actions' => ['analytics'],
                        'allow' => true,
                        'roles' => ['manager'],

                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
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
     * @return mixed
     */
    public function actionIndex()
    {
//        return $this->redirect(['login']);
         return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
//        $routes = [
//            'shop' => ['zakaz/shop'],
//            'disain' => ['zakaz/disain'],
//            'master' => ['zakaz/master'],
//            'admin' => ['zakaz/admin'],
//            'courier' => ['courier/index'],
//            'program' => ['zakaz/program'],
//            'zakup' => ['custom/index'],
//            'system' => ['helpdesk/index'],
//            ];

        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['site/index']);
//            foreach ($routes as $key => $value) {
//                if (Yii::$app->user->can($key)) {
//                    return $this->redirect(['site/index']);
//                }
//            }
        }

     /*   $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $id_user = Yii::$app->user->identity->getId();


            return $this->redirect(['site/index', 'id' => $id_user]);
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }*/
        
         $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $id_user = Yii::$app->user->identity->getId();
            if (Yii::$app->user->can('admin')){
                return $this->redirect(['zakaz/admin']);
            } else  if (Yii::$app->user->can('shop')){
                return $this->redirect(['zakaz/shop']);
            } else  if (Yii::$app->user->can('disain')){
                return $this->redirect(['zakaz/disain']);
            } else  if (Yii::$app->user->can('master')){
                return $this->redirect(['zakaz/master']);
            } else  if (Yii::$app->user->can('system')){
                return $this->redirect(['helpdesk/index']);
            } else  if (Yii::$app->user->can('zakup')){
                return $this->redirect(['custom/index']);
            } else  if (Yii::$app->user->can('courier')){
                return $this->redirect(['courier/index']);
            }else  if (Yii::$app->user->can('manager')){
                return $this->redirect(['zakaz/index']);
            }

        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['logout']);
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }
    
     /**
     * Displays analytics page.
     */
    public function actionAnalytics()
    {
        $array = AnalyticsList::getAll();
        return $this->render('analytics',['varInView' => $array]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * view accaunt setting and start and end shifts
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionSetting($id)
    {
        $model = User::findOne($id);
        // $sotrud = new Shifts();
        // $shifts = Shifts::find()->Shifts($model->id)->indexBy('id_sotrud')->all();
        // $personnel = new Personnel();

        // $formSotrud = new SotrudForm();
        // if ($formSotrud->load(Yii::$app->request->post()) && $formSotrud->validate()){
        //     $shiftsStart = new Shifts();
        //     $shiftsStart->id_sotrud = Yii::$app->request->post('SotrudForm')['sotrud'];
        //     $shiftsStart->save();
        //     Yii::$app->session->addFlash('update', 'Сотрудник '.$shiftsStart->idSotrud->nameSotrud.' начал смену');
        //     return $this->redirect(['setting', 'id' => $id]);
        // }


        return $this->render('setting', [
            'model' => $model,
            // 'sotrud' => $sotrud,
            // 'shifts' => $shifts,
            // 'personnel' => $personnel,
            // 'formSotrud' => $formSotrud,
        ]);

    }

    /**
     * end sxhifts sotrud
     * if success there is a redirect setting view
     * @return \yii\web\Response
     */
    public function actionEndSotrud()
    {
        $shifts = Shifts::findOne(['id_sotrud' => Yii::$app->request->post('SotrudForm')['sotrud'], 'end' => date('0000-00-00 00:00:00')]);
        $datetime1 = new DateTime($shifts->start);
        $datetime2 = new DateTime(date('Y-m-d H:i:s'));
        $durationSecond = abs($datetime2->getTimestamp()-$datetime1->getTimestamp());
        $formSotrud = new SotrudForm();
        if ($formSotrud->load(Yii::$app->request->post()) && $formSotrud->validate()){
            $shifts->end = date('Y-m-d H:i:s');
            $shifts->number = round($durationSecond/60);
            if (!$shifts->save()){
                print_r($shifts->getErrors());
            }
            Yii::$app->session->addFlash('update', 'Сотрудник '.$shifts->idSotrud->nameSotrud.' закончил смену');
            return $this->redirect(['setting', 'id' => Yii::$app->user->id]);
        }
    }

    public function actionManager()
    {
        $zakazSearch = new ZakazSearch();
        $helpdeskSearch = new HelpdeskSearch();
        $tododistSearch = new TodoistSearch();
        $dataProviderZakaz = $zakazSearch->search(Yii::$app->request->queryParams, 'manager');
        $dataProviderHelpdesk = $helpdeskSearch->search(Yii::$app->request->queryParams, 'overdue');
        $dataProviderTodoist = $tododistSearch->search(Yii::$app->request->queryParams, 'manager');
        $zakazAll = Zakaz::find()->where(['action' => 1])->count();
        $zakazCount = Zakaz::find()->andWhere(['action' => 1])
            ->andWhere(['<', 'srok', date('Y-m-d H:i:s')])
            ->count();

        return $this->render('manager', [
            'zakaz' => $zakazCount,
            'zakazAll' => $zakazAll,
            'dataProviderHelpdesk' => $dataProviderHelpdesk,
            'dataProviderZakaz' => $dataProviderZakaz,
            'dataProviderTodoist' => $dataProviderTodoist,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }


}
