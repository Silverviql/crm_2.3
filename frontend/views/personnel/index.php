<?php

use app\models\Personnel;
use kartik\widgets\Alert;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PersonnelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Контакты';
?>
<div class="personnel-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <p>
        <?php echo Alert::widget([
            'options' => ['class' => 'infoContact'],
            'body' => '<b>Внимание!</b> Если у Вас не форс-мажор или особая ситуация, не терпящая отлагательств (срочный крупный заказ; разгневанный клиент; любые контролирующие органы; поломка, которая сильно влияет на процесс работы), просьба звонить коллегам только в их рабочее время. Если все же случилась особая ситуация, то, в первую очередь, просьба обращаться к своему непосредственному руководителю. Если он не отвечает - то его руководителю, и так далее.'
        ]) ?>
    </p>
    <h3><?php echo Html::encode('Магазины') ?></h3>
    <table>
        <?php foreach (Personnel::getShop() as $shop){
            echo '<tr>
                <td style="padding: 8px">'.ArrayHelper::getValue($shop, 'Название').' ('.ArrayHelper::getValue($shop, 'Адрес').')</td>
                <td style="padding: 8px;width: 374px;text-align: right">'.ArrayHelper::getValue($shop, 'Телефон').'</td>
                <td style="padding: 8px;width: 374px;text-align: right">'.ArrayHelper::getValue($shop, 'Почта').'</td>
            </tr>';
        } ?>
    </table>
    <h3><?php echo Html::encode('Штат') ?></h3>
<?php Pjax::begin(); ?>

    <h3><?php /*echo Html::encode('Штат') */?></h3>
  
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'bordered' => false,
        'striped' => false,
       
        'tableOptions' => ['class' => 'table table-bordered'],
        'showHeader' => false,
        'columns' => [
            /*['class' => 'yii\grid\SerialColumn'],*/
            [
                'attribute' => 'positions',
                'filter' => \app\models\Position::find()->select(['name', 'id'])->indexBy('id')->column(),
                'value' => 'positionsAsString',
                'contentOptions' => ['class' => 'textPerTr tr250'],
            ],
            [
                'attribute' => 'nameSotrud',
                 'contentOptions' => ['class' => 'textPerTr tr210'],
            ],
            [
                'attribute' => 'phone',
                'contentOptions' => ['class' => 'textPerTr tr100'],
            ],
            [
                'attribute' => 'email',
                'contentOptions' => ['class' => 'textPerTr tr100'],
            ],
            [
                'attribute' => 'store',
                'contentOptions' => ['class' => 'textPerTr tr50'],
            ],
           /* [
                'attribute' => 'shedule',
                'value' => function($model){
                    return $model->shedule != null ? $model->shedule : false;
                },
                'contentOptions' => ['class' => 'textPerTr tr70'],
            ],*/
            [
                'attribute' => 'job_duties',
                'value' => function($model){
                    return $model->job_duties != null ? $model->job_duties : false;
                },
                'contentOptions' => ['class' => 'textPerTr'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'visible' => Yii::$app->user->can('manager'),
                'contentOptions' => ['class' => 'textPerTr'],
            ],
             [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                 'visible' => Yii::$app->user->can('manager'),
                'contentOptions' => ['class' => 'textPerTr'],
            ],
        ],
    ]); ?>
     <table>
        <?php foreach(Personnel::getSotrud() as $sotrud) {
            echo '<tr>
            <td style="padding: 8px;white-space: normal;width: 250px">' . ArrayHelper::getValue($sotrud, 'Должность') . '</td>
            <td style="padding: 8px;width: 210px">' . ArrayHelper::getValue($sotrud, 'Имя') . '</td>
            <td style="padding: 8px;width: 100px">' . ArrayHelper::getValue($sotrud, 'Телефон') . '</td>
            <td style="padding: 8px;width: 50px">' . ArrayHelper::getValue($sotrud, 'Магазин') . '</td>
            <td style="padding: 8px;width: 70px;">' . ArrayHelper::getValue($sotrud, 'График работы') . '</td>
            <td style="padding: 8px;white-space: normal">' . ArrayHelper::getValue($sotrud, 'Вопросы') . '</td>
            </tr>';
        }?>
    </table>

<?php Pjax::end(); ?></div>
