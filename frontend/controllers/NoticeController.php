<?php

namespace frontend\controllers;

use app\models\Notice;
use app\models\Notification;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class NoticeController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['shop', 'admin', 'master', 'disain'],
                    ],
                ],
            ],
        ];
    }

    public function actionCreate($id)
    {
        $request = Yii::$app->request;
        $notification = new Notification();
        if(Yii::$app->request->post()){
            $model = new Notice();
            $model->comment = $request->post('comment');
            $model->user_id = Yii::$app->user->id;
            $model->order_id = $id;
            $model->save();
            $notification->getCreateNotice(Yii::$app->user->id, $id);
            $notification->save();
            return $this->redirect(['zakaz/view', 'id' => $id]);
        }
        return $this->renderAjax('create');
    }
}
