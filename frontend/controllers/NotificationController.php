<?php

namespace frontend\controllers;

use Yii;
use app\models\Notification;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NotificationController implements the CRUD actions for Notification model.
 */
class NotificationController extends Controller
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
                        'actions' => ['index', 'ready', 'read-notice', 'open-notification'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }



    /**
     * Lists all Notification models.
     * @return mixed
     */
    public function actionIndex($new = null)
    {
        $notification = Notification::find();
        $user = Yii::$app->user->id;
        $model = $notification->where(['id_user' => $user])->limit(50)->all();
        if (Yii::$app->request->isAjax){
            if ($new){
                $model= $notification->where(['id_user' => $user, 'active' => Notification::ACTIVE])->asArray()->all();
            } else {
                $model = $notification->where(['id_user' => $user])->asArray()->all();
            }
            return json_encode($model, JSON_UNESCAPED_UNICODE);
        }
        $countNew = $notification->where(['id_user' => $user, 'active' => Notification::ACTIVE])->count();

        return $this->render('index', compact('model', 'countNew'));
    }


    /**
     *  Read all an existing Notification model.
     * If ready is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionReady($id)
    {
        $model = $this->findModel(['id_user' => $id]);
        $model->getDb()->createCommand()->update('notification', ['active' => 0], ['id_user' => $id])->execute();

        return $this->redirect(['index']);
    }

    /**
     *  One notification an existing Notification model.
     * If ready is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionReadNotice($id)
    {
        $model = $this->findModel($id);
        $model->active = Notification::NOT_ACTIVE;
        $model->save();
        return $this->redirect(['zakaz/view', 'id' => $model->id_zakaz]);
    }

    /**
     * For index click notification and changed active
     * if success there is redirect
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionOpenNotification($id)
    {
        $model = Notification::findOne($id);
        $model->active = Notification::NOT_ACTIVE;
        $model->save();

        return $this->redirect(['zakaz/view', 'id' => $model->id_zakaz]);
    }

    /**
     * Finds the Notification model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Notification the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Notification::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }    
    protected function findNotification()
    {
        $notification = Notification::find()->where(['id_user' => Yii::$app->user->id, 'active' => true]);
        if($notification->count()>50){
                $notifications = '50+';
            } elseif ($notification->count()<1){
                $notifications = '';
            } else {
                $notifications = $notification->count();
            }

        $this->view->params['notifications'] = $notification->all();
        $this->view->params['count'] =  $notifications;
    }
}
