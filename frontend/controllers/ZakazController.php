<?php

namespace frontend\controllers;

use Yii;
use app\models\Zakaz;
use app\models\Courier;
use app\models\Comment;
use app\models\Notification;
use yii\helpers\ArrayHelper;
use frontend\models\Telegram;
use app\models\ZakazSearch;
use app\models\User;
use app\models\Notice;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
/**
 * ZakazController implements the CRUD actions for Zakaz model.
 */
class ZakazController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => 'yii\filters\VerbFilter',
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            // 'caching' => [
            //     'class' => 'yii\filters\HttpCache',
            //     'only' => ['admin', 'shop', 'master', 'design'],
            //     'lastModified' => function(){
            //         return Zakaz::find()->max('date_update');
            //     }
            // ],
            'access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['shop', 'admin', 'program'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['admin', 'program'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['admin', 'design', 'master', 'program', 'shop'],
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['admin', 'design', 'master', 'program', 'shop', 'zakup', 'system', 'manager'],
                    ],
                    [
                        'actions' => ['check'],
                        'allow' => true,
                        'roles' => ['master', 'program'],
                    ],
                    [
                        'actions' => ['uploadedesign'],
                        'allow' => true,
                        'roles' => ['design', 'program'],
                    ],
                    [
                        'actions' => ['close'],
                        'allow' => true,
                        'roles' => ['admin', 'program', 'shop'],
                    ],
                    [
                        'actions' => ['restore'],
                        'allow' => true,
                        'roles' => ['admin', 'program'],
                    ],
                    [
                        'actions' => ['admin'],
                        'allow' => true,
                        'roles' => ['admin', 'program', 'manager'],
                    ],
                    [
                        'actions' => ['shop'],
                        'allow' => true,
                        'roles' => ['shop', 'program', 'manager'],
                    ],
                    [
                        'actions' => ['design'],
                        'allow' => true,
                        'roles' => ['design', 'program', 'manager'],
                    ],
                    [
                        'actions' => ['master'],
                        'allow' => true,
                        'roles' => ['master', 'program', 'manager'],
                    ],
                    [
                        'actions' => ['courier'],
                        'allow' => true,
                        'roles' => ['courier', 'program'],
                    ],
                    [
                        'actions' => ['manager'],
                        'allow' => true,
                        'roles' => ['manager', 'program'],
                    ],
                    [
                        'actions' => ['archive'],
                        'allow' => true,
                        'roles' => ['admin', 'program','manager'],
                    ],
                    [
                        'actions' => ['closeorder'],
                        'allow' => true,
                        'roles' => ['shop', 'program'],
                    ],
                    [
                        'actions' => ['ready'],
                        'allow' => true,
                        'roles' => ['design', 'program'],
                    ],
                    [
                        'actions' => ['adopted'],
                        'allow' => true,
                        'roles' => ['admin', 'program'],
                    ],
                    [
                        'actions' => ['adopdesign'],
                        'allow' => true,
                        'roles' => ['design', 'program'],
                    ],
                    [
                        'actions' => ['adopmaster'],
                        'allow' => true,
                        'roles' => ['master', 'program'],
                    ],
                    [
                        'actions' => ['statusdesign'],
                        'allow' => true,
                        'roles' => ['design', 'program'],
                    ],
                    [
                        'actions' => ['zakazedit'],
                        'allow' => true,
                        'roles' => ['admin', 'program'],
                    ],
                    [
                        'actions' => ['zakaz'],
                        'allow' => true,
                        'roles' => ['admin', 'program'],
                    ],
                    [
                        'actions' => ['comment'],
                        'allow' => true,
                        'roles' => ['admin', 'program'],
                    ],
                    [
                        'actions' => ['declined'],
                        'allow' => true,
                        'roles' => ['admin']
                    ],
                    [
                        'actions' => ['accept'],
                        'allow' => true,
                        'roles' => ['admin']
                    ],
                    [
                        'actions' => ['fulfilled'],
                        'allow' => true,
                        'roles' => ['admin']
                    ],
                    [
                        'actions' => ['reconcilation'],
                        'allow' => true,
                        'roles' => ['design']
                    ]
                ],
            ],
        ];
    }

    /**
     * Lists all Zakaz models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Zakaz();
        $notification = $this->findNotification();

        return $this->render('index', [
            'model' => $model,
            'notification' => $notification,
        ]);
    }

    /**
     * Displays a single Zakaz model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $reminder = new Notification();
        $commentField = new Comment();
        $comment = Comment::find()->zakaz($id);
        // $comment = ArrayHelper::index($comment, null, 'just_date');
        $notice = Notice::find()->where(['order_id' => $id])->orderBy('id DESC')->all();
//        $zakaz = $model->id_zakaz;

        $dataProvider = new ActiveDataProvider([
            'query' => Courier::find()->select(['date', 'to', 'from', 'commit', 'status'])->where(['id_zakaz' => $id])
        ]);

        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'comment' => $comment,
            'notice' => $notice,
            'commentField' => $commentField,
        ]);
    }

    /**
     * appointed shipping in courier
     * @param $id
     * @return string
     */
    public function actionShipping($id)
    {
        $model = $this->findModel($id);
        $user = User::findOne(['id' => User::USER_COURIER]);
        $shipping = new Courier();
        if ($model->load(Yii::$app->request->post())) {
            $shipping->save();
            $model->id_shipping = $shipping->id;
            if (!$model->save()) {
                print_r($model->getErrors());
            } else {
                $model->save();
                try{
                    /*\Yii::$app->bot->sendMessage($user->telegram_chat_id, 'Назначена доставка '.$model->prefics);*/
                }catch (Exception $e){
                    $e->getMessage();
                }
            }
        }

        return $this->render('shipping', [
            'model' => $model,
            'shipping' => $shipping,
        ]);
    }

    /**
     * Creates a new Zakaz model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Zakaz();
        $user = User::findOne(['id' => User::USER_ADMIN]);
        $notification = $this->findNotification();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file) {
                $model->upload('create');
                }
            if (!$model->save()) {
                print_r($model->getErrors());
                Yii::$app->session->addFlash('errors', 'Произошла ошибка!');
            } else {
                $model->save();
                Yii::$app->session->addFlash('update', 'Успешно создан заказ '.$model->prefics);
                try{
                    if($model->status == Zakaz::STATUS_DESIGN){
                        $user = User::findOne(['id' => User::USER_DISAYNER]);
                        if($user->telegram_chat_id){
                    /*        \Yii::$app->bot->sendMessage($user->telegram_chat_id, 'Назначен заказ '.$model->prefics.' '.$model->description);*/
                        }
                    }
                    if($user->telegram_chat_id){
                    /* \Yii::$app->bot->sendMessage($user->telegram_chat_id, 'Создан заказ '.$model->prefics.' '.$model->description);   */
                    }
                }catch (Exception $e){
                    $e->getMessage();
                }
            }

            if (Yii::$app->user->can('shop')) {
                return $this->redirect(['shop']);
            } elseif (Yii::$app->user->can('admin')) {
                return $this->redirect(['admin']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'notification' => $notification,
        ]);
    }

    /**
     * Updates an existing Zakaz model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $notification = $this->findNotification();

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if (isset($model->file)) {
                $model->upload('update', $id);
            }
            if ($model->status == Zakaz::STATUS_DESIGN or $model->status == Zakaz::STATUS_MASTER or Zakaz::STATUS_AUTSORS) {
                if($model->status == Zakaz::STATUS_DESIGN){
                    $model->statusDesign = Zakaz::STATUS_DESIGNER_NEW;
                    $model->id_unread = 0;
                } elseif($model->status == Zakaz::STATUS_MASTER){
                    $model->statusMaster = Zakaz::STATUS_MASTER_NEW;
                    $model->id_unread = 0;
                } else {
                    $model->id_unread = 0;
                }
                
            }
            $model->validate();
            $user = User::findOne(['id' => User::USER_DISAYNER]);
            if (!$model->save()) {
                print_r($model->getErrors());
                Yii::$app->session->addFlash('errors', 'Произошла ошибка!');
            } else {
                if($model->status == Zakaz::STATUS_DESIGN && $user->telegram_chat_id != null){
                    /*\Yii::$app->bot->sendMessage($user->telegram_chat_id, 'Назначен заказ '.$model->prefics.' '.$model->description);*/
                }
                $model->save();
                Yii::$app->session->addFlash('update', 'Успешно отредактирован заказ');
            }

            if (Yii::$app->user->can('shop')) {
                return $this->redirect(['shop']);
            } elseif (Yii::$app->user->can('admin')) {
                return $this->redirect(['admin']);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'notification' => $notification,
        ]);
    }

    /**
     * Master fulfilled zakaz
     * if success redirected zakaz/master
     * @param $id
     * @return \yii\web\Response
     */
    public function actionCheck($id)//Мастер выполнил свою работу
    {
        $model = $this->findModel($id);
        $user = User::findOne(['id' => 5]);
        $notification = new Notification();

        $model->status = Zakaz::STATUS_SUC_MASTER;
        $model->statusMaster = Zakaz::STATUS_MASTER_PROCESS;
        $model->id_unread = true;
        $notification->getByIdNotification(8, $id);
        $notification->saveNotification;
        if ($model->save()) {
            try{
                Yii::$app->session->addFlash('update', 'Заказ отправлен на проверку');
               /* \Yii::$app->bot->sendMessage($user->telegram_chat_id, 'Мастер выполнил работу '.$model->prefics.' '.$model->description);*/
            }catch (Exception $e){
                $e->getMessage();
            }
            return $this->redirect(['master']);
        } else {
            print_r($model->getErrors());
            Yii::$app->session->addFlash('errors', 'Произошла ошибка!');
        }
    }

    /**
     * Design fulfilled zakaz
     * @param $id
     * @return string
     */
    public function actionUploadedesign($id)
    {
        $model = $this->findModel($id);
        $user = User::findOne(['id' => 5]);

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            //Выполнение работы дизайнером
            if (isset($model->file)) {
                $model->uploadeFile;
            }
            $model->status = Zakaz::STATUS_SUC_DESIGN;
            $model->statusDesign = Zakaz::STATUS_DESIGNER_PROCESS;
            $model->id_unread = true;
            if ($model->save()) {
                if (isset($model->file)) {
                    $model->file->saveAs('maket/Maket_'.$model->id_zakaz.'.'.$model->file->extension);
                }
                try{
                    Yii::$app->session->addFlash('update', 'Заказ отправлен на проверку');
                  /*  \Yii::$app->bot->sendMessage($user->telegram_chat_id, 'Дизайнер выполнил работу '.$model->prefics.' '.$model->description);*/
                }catch (Exception $e){
                    $e->getMessage();
                }
                return $this->redirect(['design', 'id' => $id]);
            } else {
                print_r($model->getErrors());
                Yii::$app->session->addFlash('errors', 'Произошла ошибка!');
            }
        }
        return $this->renderAjax('_upload', [
            'model' => $model
        ]);
    }

    /**
     * When zakaz close Shope or Admin
     * if success then redirected shop or admin
     * @param integer $id
     * @return mixed
     */
    public function actionClose($id)
    {
        $model = $this->findModel($id);
        $model->action = 0;
        $model->date_close = date('Y-m-d H:i:s');
         if(($model->oplata - $model->fact_oplata) !== 0){
            Yii::$app->session->addFlash('errors', 'Нельзя закрыть неоплаченный!');
            return $this->redirect(['zakaz/update', 'id'=> $model->id_zakaz ]);

        } else {
            if (!$model->save()) {
                Yii::$app->session->addFlash('errors', 'Произошла ошибка');
                print_r($model->getErrors());
            } else {
                $model->save();
                Yii::$app->session->addFlash('update', 'Заказ успешно закрылся №'.$model->prefics);
            }
        
        //        $this->view->params['notifications'] = Notification::find()->where(['id_user' => Yii::$app->user->id, 'active' => true])->all();
        
            if (Yii::$app->user->can('shop')) {
                return $this->redirect(['shop']);
            } elseif (Yii::$app->user->can('admin')) {
                return $this->redirect(['admin']);
            }
        }
    }

    public function actionRestore($id)
    {
        $model = $this->findModel($id);
        $model->action = 1;
        $model->restoring = 1;
        $model->save();
        Yii::$app->session->addFlash('update', 'Заказ успешно активирован');

        return $this->redirect(['archive']);
    }

    /**
     * New zakaz become in status adopted
     * @param $id
     * @return \yii\web\Response
     */
    public function actionAdopted($id)
    {
        $model = $this->findModel($id);
        $model->status = Zakaz::STATUS_ADOPTED;
        $model->save();
    }

    /**
     * New zakaz become in status wokr for design
     * @param $id
     * @return \yii\web\Response
     */
    public function actionAdopdesign($id)
    {
        $model = $this->findModel($id);
        $model->statusDesign = Zakaz::STATUS_DESIGNER_WORK;
        $model->save();
    }

    /**
     * New zakaz become in status wokr for master
     * @param $id
     * @return \yii\web\Response
     */
    public function actionAdopmaster($id)
    {
        $model = $this->findModel($id);
        $model->statusMaster = Zakaz::STATUS_MASTER_WORK;
        $model->save();
    }

    /**
     * Zakaz fulfilled
     * if success then redirected zakaz/admin
     * @param $id
     * @return \yii\web\Response
     */
    public function actionFulfilled($id)
    {
        $model = $this->findModel($id);
        $model->status = Zakaz::STATUS_EXECUTE;
        $model->id_unread = 0;
        if ($model->save()) {
            Yii::$app->session->addFlash('update', 'Выполнен заказ №'.$model->prefics);
            return $this->redirect(['admin']);
        } else {
            print_r($model->getErrors());
            Yii::$app->session->addFlash('errors', 'Произошла ошибка!');
        }
    }

    /**
     * Zakaz the designer
     * if success then redirected zakaz/design
     * @param $id
     * @return \yii\web\Response
     */
    public function actionReconcilation($id)
    {
        $model = $this->findModel($id);

        if ($model->statusDesign == Zakaz::STATUS_DESIGNER_SOGLAS) {
            $model->statusDesign = Zakaz::STATUS_DESIGNER_WORK;
        } else {
            $model->statusDesign = Zakaz::STATUS_DESIGNER_SOGLAS;
        }
        if ($model->save()) {
            return $this->redirect(['design']);
        } else {
            print_r($model->getErrors());
        }
    }

    /**
     * All existing close zakaz in Admin
     * @return string
     */
    public function actionArchive()
    {
        $searchModel = new ZakazSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'archive');
        $notification = $this->findNotification();

        return $this->render('archive', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'notification' => $notification,
        ]);
    }

    /** All close zakaz in shop */
    public function actionCloseorder()
    {
        $searchModel = new ZakazSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'closeshop');
        $notification = $this->findNotification();

        return $this->render('closeorder', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'notification' => $notification,
        ]);
    }

    /** All fulfilled design */
    public function actionReady()
    {
        $searchModel = new ZakazSearch();
        $dataProvider = new ActiveDataProvider([
            'query' => Zakaz::find()->andWhere(['status' => Zakaz::STATUS_SUC_DESIGN, 'action' => 1]),
            'sort' => ['defaultOrder' => ['srok' => SORT_DESC]]
        ]);
        $notification = $this->findNotification();

        return $this->render('ready', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'notification' => $notification,
        ]);
    }

    /**
     * Design internal status zakaz
     * @param $id
     * @return \yii\web\Response
     */
    public function actionStatusdesign($id)
    {
        $model = $this->findModel($id);
        $model->statusDesign = Zakaz::STATUS_DESIGNER_WORK;
        $model->save();

        return $this->redirect(['view', 'id' => $model->id_zakaz]);
    }

    /**
     * Deletes an existing Zakaz model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    /** START view role */
    /**
     * All zakaz existing in Shop
     * @return string
     */
    public function actionShop()
    {
        $searchModel = new ZakazSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'shopWork');
        $dataProviderExecute = $searchModel->search(Yii::$app->request->queryParams, 'shopExecute');
        $notification = $this->findNotification();

        return $this->render('shop', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProviderExecute' => $dataProviderExecute,
            'notification' => $notification,
        ]);
    }
    
    public function actionManager($id)
    {
        $searchModel = new ZakazSearch();
        $dataProvider  = $searchModel->searchmanager(Yii::$app->request->queryParams, 'shopWork', $id);
        $dataProviderExecute = $searchModel->searchmanager(Yii::$app->request->queryParams, 'shopExecute', $id);
        $notification = $this->findNotification();

        return $this->render('manager', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProviderExecute' => $dataProviderExecute,
            'notification' => $notification,
        ]);
    }

    /**
     * All zakaz existing in Desgin
     * @return string
     */
    public function actionDesign()
    {
        $searchModel = new ZakazSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'design');
        $dataProviderSoglas = $searchModel->search(Yii::$app->request->queryParams, 'designSoglas');
        $notification = $this->findNotification();
        $dataProvider->pagination = false;

        return $this->render('design', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProviderSoglas' => $dataProviderSoglas,
            'notification' => $notification,
        ]);
    }
    
    /**
     * All zakaz existing in Master
     * @return string
     */
    public function actionMaster()
    {
        $searchModel = new ZakazSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'master');
        $dataProviderSoglas = $searchModel->search(Yii::$app->request->queryParams, 'masterSoglas');
        $notification = $this->findNotification();
        $dataProvider->pagination = false;

        return $this->render('master', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProviderSoglas' => $dataProviderSoglas,
            'notification' => $notification,
        ]);
    }

    /**
     * All zakaz existing in Admin
     * @return string|\yii\web\Response
     * windows Admin
     */
    public function actionAdmin()
    {
        $notification = $this->findNotification();
        $notifications = new Notification();
        $model = new Zakaz();
        $comment = new Comment();
        $telegram = new Telegram();
        $shipping = new Courier();
        $user = User::findOne(['id' => 7]);

        if ($comment->load(Yii::$app->request->post())) {
            if ($comment->save()) {
                return $this->redirect(['admin']);
            } else {
                print_r($comment->getErrors());
            }
        }

        if ($shipping->load(Yii::$app->request->post())) {
            $shipping->save();//сохранение доставка
            if (!$shipping->save()) {
                $this->flashErrors();
            }
            $model = Zakaz::findOne($shipping->id_zakaz);//Определяю заказ
            $model->id_shipping = $shipping->id;//Оформление доставку в таблице заказа
            if ($model->save()){
                /** @var $model \app\models\Zakaz */
                Yii::$app->session->addFlash('update', 'Доставка успешно создана');
               /* $telegram->message(User::USER_COURIER, 'Назначена доставка '.$model->prefics);*/
            } else {
                $this->flashErrors();
            }

            $notifications->getByIdNotification(7, $shipping->id_zakaz);//оформление уведомлений
            $notifications->saveNotification;

            return $this->redirect(['admin', '#' => $model->id_zakaz]);
        }

        $searchModel = new ZakazSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'admin');
        $image = $model->img;

        $dataProviderNew = $searchModel->search(Yii::$app->request->queryParams, 'adminNew');
        $dataProviderWork = $searchModel->search(Yii::$app->request->queryParams, 'adminWork');
        $dataProviderIspol = $searchModel->search(Yii::$app->request->queryParams, 'adminIspol');
       
        $dataProvider  ->sort->defaultOrder['srok']=SORT_ASC;
        $dataProviderNew  ->sort->defaultOrder['srok']=SORT_DESC;
        $dataProviderWork  ->sort->defaultOrder['srok']=SORT_ASC;
        $dataProviderIspol  ->sort->defaultOrder['srok']=SORT_ASC;
        $dataProviderNew->pagination = false;
        $dataProviderWork->pagination = false;
      /*  $dataProviderIspol->pagination = false;*/
        $dataProvider->pagination = false;


        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProviderNew' => $dataProviderNew,
            'dataProviderWork' => $dataProviderWork,
            'dataProviderIspol' => $dataProviderIspol,
            'image' => $image,
            'shipping' => $shipping,
            'notification' => $notification,
        ]);
    }
    /** END view role */
    /** START Block admin in gridview */
    /**
     * Zakaz deckined admin and in db setup STATUS_DECLINED_DESIGN or STATUS_DECLINED_MASTER
     * if success then redirected view admin
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionDeclined($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Zakaz::SCENARIO_DECLINED;
        if ($model->status == Zakaz::STATUS_SUC_DESIGN) {
            $user_id = User::USER_DISAYNER;
        } else {
            $user_id = User::USER_MASTER;
        }
        $user = User::findOne(['id' => $user_id]);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->status == Zakaz::STATUS_SUC_DESIGN) {
                    $model->status = Zakaz::STATUS_DECLINED_DESIGN;
                    $model->statusDesign = Zakaz::STATUS_DESIGNER_DECLINED;
                    $model->id_unread = 0;
                } else {
                    $model->status = Zakaz::STATUS_DECLINED_MASTER;
                    $model->statusMaster = Zakaz::STATUS_MASTER_DECLINED;
                    $model->id_unread = 0;
                }
                if (!$model->save()) {
                    print_r($model->getErrors());
                    Yii::$app->session->addFlash('errors', 'Проищошла ошибка!');
                } else {
                    $model->save();
                    Yii::$app->session->addFlash('update', 'Работа была отклонена!');
                    try {
                        if($user->telegram_chat_id){
                           /* \Yii::$app->bot->sendMessage($user->telegram_chat_id, 'Отклонен заказ ' . $model->prefics . ' По причине: ' . $model->declined);   */
                        }
                    } catch (Exception $e) {
                        $e->getMessage();
                    }
                }
                return $this->redirect(['admin', '#' => $model->id_zakaz]);
            } else {
                return $this->renderAjax('_declined', ['model' => $model]);
            }
        } else {
            return $this->renderAjax('_declined', ['model' => $model]);
        }
    }

    /**
     * * Zakaz accept admin and in appoint
     * if success then redirected view admin
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionAccept($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->status == Zakaz::STATUS_DESIGN or $model->status == Zakaz::STATUS_MASTER or $model->status == Zakaz::STATUS_AUTSORS) {
                    if ($model->status == Zakaz::STATUS_DESIGN) {
                        $model->statusDesign = Zakaz::STATUS_DESIGNER_NEW;
                        $model->id_unread = 0;
                        $user_id = User::USER_DISAYNER;
                    } elseif ($model->status == Zakaz::STATUS_MASTER) {
                        $model->statusMaster = Zakaz::STATUS_MASTER_NEW;
                        $model->id_unread = 0;
                        $user_id = User::USER_MASTER;
                    } else {
                        $model->id_unread = 0;
                    }
                }
                if ($model->save()) {
                    if($model->status == Zakaz::STATUS_DESIGN){
                        $user = User::findOne(['id' => $user_id]);
                        try{
                            Yii::$app->session->addFlash('update', 'Работа была принята');
                            if($user->telegram_chat_id){
                               /* \Yii::$app->bot->sendMessage($user->telegram_chat_id, 'Назначен заказ '.$model->prefics.' '.$model->description);   */
                            }
                        }catch (Exception $e){
                            $e->getMessage();
                        }
                    }
                    return $this->redirect(['admin', 'id' => $id]);
                } else {
                    print_r($model->getErrors());
                    Yii::$app->session->addFlash('errors', 'Произошла ошибка!');
                }
            } else {
                return $this->renderAjax('accept', ['model' => $model]);
            }
        }
        return $this->renderAjax('accept', ['model' => $model]);
    }

    /**
     * Bloc view zakaz in Admin
     * @param $id
     * @return string
     */
    public function actionZakaz($id)
    {
        $model = $this->findModel($id);

        return $this->renderPartial('_zakaz', [
            'model' => $model,
        ]);
    }
    /** END Block admin in gridview*/
    /**
     * Finds the Zakaz model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Zakaz the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Zakaz::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findShipping($id)
    {
        if (($shipping = Courier::findOne($id)) !== null) {
            return $shipping;
        } else {
            throw new NotFoundHttpException("The requested page does not exist.");

        }
    }

    protected function findNotification()
    {
        $notifModel = Notification::find();
        $notification = $notifModel->where(['id_user' => Yii::$app->user->id, 'active' => true]);
        if ($notification->count() > 50) {
            $notifications = '50+';
        } elseif ($notification->count() < 1) {
            $notifications = '';
        } else {
            $notifications = $notification->count();
        }

        $this->view->params['notifications'] = $notification->all();
        $this->view->params['count'] = $notifications;
    }
}
