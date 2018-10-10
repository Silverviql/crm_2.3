<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Nav;
/* @var $this yii\web\View */
/* @var $searchModel app\models\HelpdeskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Help Desk';
?>
<?php Pjax::begin(); ?>
<div class="helpdesk-index">
    <?php echo Nav::widget([
		'options' => ['class' => 'nav nav-pills'],
		'items' => [
		['label' => 'Администратор', 'url' => ['zakaz/admin'], 'visible' => Yii::$app->user->can('seeAdmin')],
		['label' => 'Дизайнер', 'url' => ['zakaz/disain'], 'visible' => Yii::$app->user->can('disain')],
		['label' => 'Готовые заказы', 'url' => ['zakaz/ready'], 'visible' => Yii::$app->user->can('disain')],
		['label' => 'Мастер', 'url' => ['zakaz/master'], 'visible' => Yii::$app->user->can('master')],
		['label' => 'Прием заказов', 'url' => ['zakaz/shop'], 'visible' => Yii::$app->user->can('seeShop')],
		['label' => 'Закрытые заказы', 'url' => ['zakaz/archive'], 'visible' => Yii::$app->user->can('seeAdmin')],
		['label' => 'Курьер', 'url' => ['courier/index'], 'visible' => Yii::$app->user->can('courier')],
		['label' => 'Закрытые заказы', 'url' => ['zakaz/closezakaz'], 'visible' => Yii::$app->user->can('seeShop')],
		['label' => 'Прочее', 'items' => [
			['label' => 'Задачник', 'url' => ['todoist/index'], 'visible' => Yii::$app->user->can('admin')],
			['label' => 'Задачи', 'url' => ['todoist/shop'], 'visible' => Yii::$app->user->can('shop')],
			['label' => 'Help Desk', 'url' => ['helpdesk/index']],
			['label' => 'Запросы на товар', 'url' => ['custom/adop'], 'visible' => Yii::$app->user->can('shop')],
		], 'visible' => Yii::$app->user->can('seeAdop')],
		['label' => 'Создать запрос', 'url' => ['todoist/create_shop'], 'visible' =>Yii::$app->user->can('shop')],
		['label' => 'Задачник', 'url' => ['todoist/shop'], 'visible' =>Yii::$app->user->can('seeAllIspol')],
		['label' => 'Запросы на товар', 'url' => ['custom/index'], 'visible' => Yii::$app->user->can('zakup')],
		['label' => 'Help Desk', 'url' => ['helpdesk/index'], 'visible' => Yii::$app->user->can('zakup')],
		['label' => 'Help Desk', 'url' => ['helpdesk/index'], 'visible' => Yii::$app->user->can('disain')],
		],
	]); ?>

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
       	<?php if(!(Yii::$app->user->can('system') or Yii::$app->user->can('shop'))):?>
		<?= Html::a('Создать заказ', ['create'], ['class' => 'btn btn-success']) ?>
       	<?php endif; ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_user',
            'commetnt:ntext',
//            'status',
            'date',
            'sotrud',
			[
                'attribute' => '',
                'format' => 'raw',
                'value' => function($model) {
					if($model->status == 0){
						return Html::a('Решена', ['helpdesk/close', 'id' => $model->id]);
					} else {
						return '';
					}
                },
				'visible' => Yii::$app->user->can('system')
            ],

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
<?php Pjax::end(); ?>
