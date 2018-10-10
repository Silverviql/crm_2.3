<?php

namespace frontend\controllers;

use app\models\Choice;
use app\models\Image;
use app\models\Thema;
use \Yii;
use app\models\Questions;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;

class TestController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'delete','update-theme','test', 'result-test'],
                        'allow' => true,
                        'roles' => ['hr']
                    ],
                    [
                        'actions' => ['index', 'testing', 'result'],
                        'allow' => true,
                        'roles' => ['employee']
                    ]
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate()
    {
        $model = new Questions();
        $themaModel = new Thema();
        $request = Yii::$app->request;
        $thema = $request->post('Thema');
        $question = $request->post('Question');
        $answer = $request->post('Answer');
        $right = $request->post('right');
        if ($request->post()){
            if ((int)$thema != 0){
                $model->id_theme = (int)$thema;
            } else {
                $themaModel->name = $thema;
                if (!$themaModel->save()) {
                    print_r($themaModel->getErrors());
                }
                $model->id_theme = $themaModel->id;
            }
            $model->name = $question;
            $model->answear = Json::encode($answer, JSON_UNESCAPED_UNICODE);
            $model->correct = '{"right": "'.$answer[$right].'"}';
            if(!$model->save()){
                print_r($model->getErrors());
            } else {
                $model->save();
                if ($_FILES['attachment']){
                    $model->upload($model->id);
                };
                return $this->redirect(['test/test', 'id' => $model->id_theme]);
            }
        }
    }

    public function actionUpdate($id)
    {
        $model = Questions::findOne($id);
        $request = Yii::$app->request;
        if ($request->post()){
            if ($_FILES['attachment']){
                $model->upload($id);
            }
            $model->name = $request->post('Question');
            $model->answear = json_encode($request->post('Answer'), JSON_UNESCAPED_UNICODE);
            $model->correct = '{"right": "'.$request->post('right').'"}';
            if (!$model->save()){
                print_r($model->getErrors());
            }
            return $this->redirect(['test/test', 'id' => $model->id_theme]);
        }

        return $this->renderAjax('update', [
            'model' => $model
        ]);
    }

    public function actionUpdateTheme($id)
    {
        $model = Thema::findOne($id);
        if($model->load(Yii::$app->request->post())){
            if (!$model->save()){
                print_r($model->getErrors());
            } else {
                return $this->redirect(['test', 'id' => $id]);
            }
        }
        return $this->renderAjax('update-theme', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = Questions::findOne($id);
        $model->active = Questions::NOT_ACTIVE;
        $model->correct = json_encode($model->correct, JSON_UNESCAPED_UNICODE);
        $model->answear = json_encode($model->answear, JSON_UNESCAPED_UNICODE);
        if(!$model->save()){
            print_r($model->getErrors());
        };
        return $this->redirect(['test', 'id' => $model->id_theme]);
    }

    public function actionTesting($id)
    {
        $model = Questions::find()->where(['id_theme' => $id])->all();
        $right = 0;
        $done = null;
        if (Yii::$app->request->post('Answear')){
            foreach ($model as $value){
                foreach ($value->correct as $key => $correct){
                    if (Yii::$app->request->post('Answear')[$value->id] == $correct){
                        $right++;
                    };
                }
            }
            $choice = new Choice();
            $choice->id_theme = $model[0]->id_theme;
            $choice->answear = json_encode(Yii::$app->request->post('Answear'), JSON_UNESCAPED_UNICODE);
            $choice->result = $right;
            if (!$choice->save()){
                print_r($choice->getErrors());
            }
            if ($right == 15){
                return $this->redirect(['test/result', 'message' => 'Тест пройден', 'right' => $right]);
            } else {
                return $this->redirect(['test/result', 'message' => 'Тест провален', 'right' => $right]);
            }
        }

        return $this->render('test', [
            'model' => $model,
            'right' => $right,
            'done' => $done,
        ]);
    }

    public function actionResultTest()
    {
        $query = Choice::find();
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 5]);
        $model = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('result-test', [
            'model' => $model,
            'pages' => $pages
        ]);
    }

    public function actionResult($message, $right)
    {
        return $this->render('result', [
            'message' => $message,
            'right' => $right
        ]);
    }

    public function actionTest($id)
    {
        $thema = Thema::find()->where(['id' => $id])->one();
        $model = Questions::find()->where(['id_theme' => $id, 'active' => Questions::ACTIVE])->all();

        return $this->render('admin-test', [
            'model' => $model,
            'thema' => $thema
        ]);
    }
}
