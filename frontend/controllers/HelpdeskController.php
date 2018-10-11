<?php

namespace frontend\controllers;

use app\models\Comment;
use app\models\User;
use app\models\Zakaz;
use frontend\models\Telegram;
use Yii;
use app\models\Helpdesk;
use app\models\HelpdeskSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * HelpdeskController implements the CRUD actions for Helpdesk model.
 */
class HelpdeskController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
    					'actions' => ['index', 'create', 'approved', 'declined-help'],
    					'allow' => true,
    					'roles' => ['admin', 'design', 'master', 'system', 'zakup', 'shop', 'manager'],
					],
                    [
                        'actions' => ['overdue'],
                        'allow' => true,
                        'roles' => ['manager'],
                    ],
					[
						'actions' => ['close'],
						'allow' => true,
						'roles' => ['system'],
					],
                    [
                        'actions' => ['detail'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
				]
			]
        ];
    }

    /**
     * Lists all Helpdesk models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HelpdeskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'work');
        $dataProviderSoglas = $searchModel->search(Yii::$app->request->queryParams, 'soglas');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProviderSoglas' => $dataProviderSoglas,
        ]);
    }

    /**
     * Displays a single Helpdesk model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Helpdesk model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Helpdesk();
        $telegram = new Telegram();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if($model->save()){
                Yii::$app->session->addFlash('update', 'Заявка успешно создана');
               /* $telegram->message(User::USER_SYSTEM, 'Назначена заявка на поломку '.$model->commetnt);*/
                return $this->redirect(['index', 'id' => $model->id]);
            } else {
                $this->flashErrors();
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Helpdesk model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * View for manager sees expired helpdesk
     * @return string
     */
    public function actionOverdue()
    {
        $searchModel = new HelpdeskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'overdue');

        return $this->render('overdue', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Deletes an existing Helpdesk model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

	/**
     * in Approved an existing Helpdesk model.
     * System fulfilled problem.
     * If close is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionClose($id)
    {
		if ($model = $this->findModel($id)) {
            $model->status = Helpdesk::STATUS_CHECKING;
            $model->save();
        }

		return $this->redirect(['index']);
    }

    /**
     * The customer clicked on to take
     * Problem solved and stamped datetime
     * if success redirected, the browser will be redirected to the 'index' page.
     * @param $id
     * @return \yii\web\Response
     */
    public function actionApproved($id)
    {
        $model = $this->findModel($id);
        $model->status = Helpdesk::STATUS_APPROVED;
        $model->endDate = date('Y-m-d H:m:s');
        $model->save();
        Yii::$app->session->addFlash('update', 'Заявка была закрыта');

        return $this->redirect(['index']);
    }

    /**
     * Page for eclined problem
     * if we receive s POST request, add model->status STATUS_DECLINED
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionDeclinedHelp($id)
    {
        $model = $this->findModel($id);
        $telegram  = new Telegram();

        if ($model->load(Yii::$app->request->post())){
            $model->status = Helpdesk::STATUS_DECLINED;
            if (!$model->save()){
               $this->flashErrors($id);
            } else {
                /*$telegram->message(User::USER_SYSTEM, 'Отклонена поломку '.$model->commetnt.' По причине: '.$model->declined);*/
            }
        }

        return $this->renderAjax('declined-help', ['model' => $model]);
    }

    public function actionDetail()
    {
        $id = Yii::$app->request->post('expandRowKey');
        $model = $this->findModel($id);
        $comment = Comment::find()->comment($id);
        $commentForm = new Comment();

        if (isset($id)){
            return $this->renderPartial('detail', [
                'model'=>$model,
                'comment' => $comment,
                'commentForm' => $commentForm,
            ]);
        } else {
            return '<div class="alert alert-danger">Страница не найдена</div>';
        }
    }

    /**
     * Finds the Helpdesk model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Helpdesk the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Helpdesk::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param null $id
     */
    private function flashErrors($id = null)
    {
        /** @var $model \app\models\Zakaz */
        $id == null ? $model = new Zakaz() : $this->findModel($id);
        Yii::$app->session->addFlash('errors', 'Произошла ошибка! '.$model->getErrors());
    }
}
