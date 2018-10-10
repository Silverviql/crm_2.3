<?php

namespace frontend\controllers;

use app\models\User;
use app\models\Zakaz;
use frontend\models\Telegram;
use Yii;
use app\models\Courier;
use app\models\Notification;
use app\models\CourierSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * CourierController implements the CRUD actions for Courier model.
 */
class CourierController extends Controller
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
                    'delete' => ['POST'],
                ],
           ],
           'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                   [
                       'actions' => ['index', 'make', 'delivered'],
                       'allow' => true,
                       'roles' => ['courier'],
                   ],
                   [
                       'actions' => ['ready'],
                       'allow' => true,
                       'roles' => ['courier', 'admin']
                   ],
                   [
                        'actions' => ['shipping', 'deletes', 'create', 'create-zakaz', 'update'],
                        'allow' => true,
                        'roles' => ['admin', 'program', 'manager'],
                   ],
                ],
            ],
        ];
    }

    /**
     * Lists all Courier models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CourierSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'courier');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionReady()
    {
        $courier = Courier::find();
        $searchModel = new CourierSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'ready');
        $dataProvider ->sort->defaultOrder['data_from']=SORT_DESC;
        return $this->render('ready', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /** View for admin scans all active shipping */
    public function actionShipping()
    {
        $courier = Courier::find();
        $searchModel = new CourierSearch();
        $dataProvider = new ActiveDataProvider([
            'query' => $courier->where(['status' => Courier::DOSTAVKA]),
            'pagination' => ['pageSize' => 50,]
        ]);

        return $this->render('shipping', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Delete shipping after courier not accepted shipping
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDeletes($id)
    {
        $model =  $this->findModel($id);
        $telegram = new Telegram();
        $model->status = Courier::CANCEL;
        if(!$model->save()){
            $this->flashErrors($id);
        } else {
            Yii::$app->session->addFlash('update', 'Доставка была отклонена');
            if ($model->id_zakaz == null){
               /* $telegram->message(User::USER_COURIER, 'Отменена доставка '.$model->commit);*/
            } else {
                /*$telegram->message(User::USER_COURIER, 'Отменена доставка '.$model->idZakaz->prefics.' '.$model->commit);*/
            }
        }

        return $this->redirect(['shipping']);
    }

    /**
     * Displays a single Courier model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Courier model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Courier();
        $telegram = new Telegram();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()){
                Yii::$app->session->addFlash('update', 'Доставка была назначена');
                /*$telegram->message(User::USER_COURIER, 'Назначена доставка.'.PHP_EOL.$model->commit.PHP_EOL.'Откуда: '.$model->to.PHP_EOL.'Куда: '.$model->from);*/
                return $this->redirect('shipping');
            } else {
                print_r($model->getErrors());
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCreateZakaz($id)
    {
        $model = $id;
        $shipping = new Courier();
        $telegram = new Telegram();
        $notifications = new Notification();

        if ($shipping->load(Yii::$app->request->post()) && $shipping->validate()) {
            $shipping->save();//сохранение доставка
            if (!$shipping->save()) {
                print_r($shipping->getErrors());
            }
            $model = Zakaz::findOne(['id_zakaz' => $id]);//Определяю заказ
            $model->id_shipping = $shipping->id;//Оформление доставку в таблице заказа
            if ($model->save()){
                /** @var $model \app\models\Zakaz */
                Yii::$app->session->addFlash('update', 'Доставка успешно создана');
                /*$telegram->message(User::USER_COURIER, 'Назначена доставка '.$model->prefics.PHP_EOL.$shipping->commit.PHP_EOL.'Откуда: '.$shipping->to.PHP_EOL.'Куда: '.$shipping->from);*/
            } else {
                print_r($model->getErrors());
            }

            $notifications->getByIdNotification(7, $shipping->id_zakaz);//оформление уведомлений
            $notifications->saveNotification;

            return $this->redirect(['zakaz/admin', '#' => $model->id_zakaz]);
        }

        return $this->renderAjax('create-zakaz', [
            'model' => $model,
            'shipping' => $shipping
        ]);
    }

    /**
     * Updates an existing Courier model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            return $this->redirect(['shipping']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Courier model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Courier took delivery
     * If success redirected index view
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionMake($id)//Курьер забрал заказ
    {
        $model = $this->findModel($id);
        $notification = new Notification();

        $model->data_to = date('Y-m-d H:i:s');
        $model->status = Courier::RECEIVE;

//        $notification->getByIdNotification(5, $model->id_zakaz);//Уведомление, что курьер забрал доставку
//        $notification->saveNotification;

        if ($model->save()){
            return $this->redirect(['index']);
        } else {
            print_r($model->getErrors());
        }
    }

    /**
     * Courier delivered shipping
     * If success redirected index view
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDelivered($id)//Курьер доставил заказ
    {
        $model = $this->findModel($id);
        $notification = new Notification();
        $model->data_from = date('Y-m-d H:i:s');
        $model->status = Courier::DELIVERED;
        $model->delivery_time = date('Y-m-d H:i:s');

//        $notification->getByIdNotification(8, $model->id_zakaz);//Уведомление, что курьер доставил доставку
//        $notification->saveNotification;

        if ($model->save()){
            return $this->redirect(['index']);
        } else {
            print_r($model->getErrors());
        }
    }
    /**
     * Finds the Courier model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Courier the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Courier::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param null $id
     * @throws NotFoundHttpException
     */
    private function flashErrors($id = null)
    {
        /** @var $model \app\models\Zakaz */
        $id == null ? $model = new Zakaz() : $this->findModel($id);
        Yii::$app->session->addFlash('errors', 'Произошла ошибка! '.$model->getErrors());
    }
}
