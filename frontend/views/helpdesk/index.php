<?php

use app\models\Helpdesk;
use yii\bootstrap\ButtonDropdown;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\HelpdeskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $dataProviderSoglas yii\data\ActiveDataProvider */

$this->title = 'ВСЕ ПОЛОМКИ';
?>
<?php Pjax::begin(); ?>
<div class="helpdesk-index">

    <p>
        <?php if (Yii::$app->user->can('design')): ?>
         <div class="button-dropmenu">
        <!--<?= Html::a('+', ['create'], ['class' => 'buttonAdd btn-group'])?>-->
        <?php echo ButtonDropdown::widget([
                'label' => '+',
                'options' => [
                    'class' => 'btn buttonAdd',
                ],
                'dropdown' => [
                    'items' => [
                        [
                            'label' => 'Поломки',
                            'url' => ['helpdesk/create']
                        ],
                    ]
                ]
            ]); ?>
        </div>
        <?php endif ?>
       	<?php if(!(Yii::$app->user->can('system'))):?>
            <?php if (!Yii::$app->user->can('design')): ?>
             <div class="button-dropmenu">
            <?php echo ButtonDropdown::widget([
                'label' => '+',
                'options' => [
                    'class' => 'btn buttonAdd',
                ],
                'dropdown' => [
                    'items' => [
                        [
                            'label' => 'Заказ',
                            'url' => ['zakaz/create'],
                            'visible' => Yii::$app->user->can('seeAdop'),
                        ],
                        [
                            'label' => '',
                            'options' => [
                                'role' => 'presentation',
                                'class' => 'divider'
                            ]
                        ],
                        [
                            'label' => 'Закупки',
                            'url' => ['custom/create'],
                            'visible' => !Yii::$app->user->can('design'),
                        ],
                        [
                            'label' => '',
                            'options' => [
                                'role' => 'presentation',
                                'class' => 'divider'
                            ]
                        ],
                        [
                            'label' => 'Поломки',
                            'url' => ['helpdesk/create']
                        ],
                        [
                            'label' => '',
                            'options' => [
                                'role' => 'presentation',
                                'class' => 'divider'
                            ]
                        ],
                        [
                            'label' => 'Задачи',
                            'url' => ['todoist/create'],
                        ],
                        [
                            'label' => '',
                            'options' => [
                                'role' => 'presentation',
                                'class' => 'divider'
                            ]
                        ],
                        [
                            'label' => 'Доставка',
                            'url' => ['courier/create'],
                            'visible' => Yii::$app->user->can('admin'),
                        ],
                    ]
                ]
            ]); ?>
            </div>
            <?php endif ?>
       	<?php endif; ?>
    </p>

    <h3>В работе</h3>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'floatHeader' => true,
        'headerRowOptions' => ['class' => 'headerTable'],
        'pjax' => true,
        'tableOptions' 	=> ['class' => 'table table-bordered tableSize'],
        'striped' => false,
        'rowOptions' => ['class' => 'trTable trNormal'],
        'columns' => [
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '1px',
                'enableRowClick' => true,
                'expandOneOnly' => true,
                'expandIcon' => '<span class="glyphicon glyphicon-chevron-right"></span>',
                'collapseIcon' => '<span class="glyphicon glyphicon-chevron-down"></span>',
                'detailUrl' => Url::to(['detail']),
                'value' => function(){
                    return GridView::ROW_COLLAPSED;
                },
                'contentOptions' => ['class' => 'border-left textTr', 'style' => 'border:none'],

            ],
            [
                'attribute' => 'id',
                'hAlign' => GridView::ALIGN_RIGHT,
                'contentOptions' => ['class' => 'textTr tr50', 'style' => 'border:none'],
            ],
            [
                'attribute' => 'date',
                'format' => ['date', 'php:d M H:i'],
                'hAlign' => GridView::ALIGN_RIGHT,
                'contentOptions' => ['class' => 'textTr srok tr90'],
            ],
            [
				'attribute' => 'commetnt',
				'format' => 'text',
				'contentOptions'=>['style'=>'white-space: normal;'],
			],
//            [
//                'attribute' => 'declined',
//                'format' => 'raw',
//                'contentOptions' => ['class' => 'textTr tr20'],
//            ],
            [
                'attribute' => 'id_user',
                'value' => 'idUser.name',
                'contentOptions' => ['class' => 'textTr tr90'],
                'hAlign' => GridView::ALIGN_RIGHT,
                'visible' => Yii::$app->user->can('system'),
            ],
//            [
//                'attribute' => '',
//                'format' => 'raw',
//                'contentOptions' => ['class' => 'textTr tr90'],
//                'value' => function($model){
//                    return $model->status == Helpdesk::STATUS_CHECKING ? Html::a('Принять', ['approved', 'id' => $model->id]).''.Html::a('Отклонить', ['#'], ['class' => 'declinedHelp', 'value' => Url::to(['declined-help', 'id' => $model->id])]) : '';
//                },
//                'visible' => !Yii::$app->user->can('system')
//            ],
            [
                'attribute' => 'sotrud',
                'contentOptions' => ['class' => 'textTr tr50'],
            ],
            [
                'attribute' => 'statusHelpName',
                'format' => 'raw',
                'contentOptions' => function($model){
                    if ($model->status == Helpdesk::STATUS_CHECKING){
                        return Yii::$app->user->can('system') ? ['class' => 'textTr successHelp tr90'] : ['class' => 'border-right successHelp textTr'];
                        } else {
                        return Yii::$app->user->can('system') ? ['class' => 'textTr tr90'] : ['class' => 'border-right textTr'];
                    }
                },
                'hAlign' => GridView::ALIGN_LEFT,
                'value' => function($model){
                    if ($model->status == Helpdesk::STATUS_DECLINED){
                        return Html::tag('span', Html::encode($model->statusHelpName), [
                            'title' => $model->declined,
                            'data-toggle' => 'tooltip',
                            'class' => 'declined',
                        ]);
                    } else {
                        return $model->statusHelpName;
                    }
                }
            ],
			[
                'attribute' => '',
                'format' => 'raw',
                'contentOptions' => ['class' => 'border-right textTr'],
                'value' => function($model) {
					if($model->status == Helpdesk::STATUS_NEW or $model->status == Helpdesk::STATUS_DECLINED){
						return Html::a('Решена', ['helpdesk/close', 'id' => $model->id]);
					} else {
						return '';
					}
                },
				'visible' => Yii::$app->user->can('system')
            ],
        ],
    ]); ?>

    <h3>На проверке</h3>
    <?= GridView::widget([
        'dataProvider' => $dataProviderSoglas,
        'floatHeader' => true,
        'headerRowOptions' => ['class' => 'headerTable'],
        'pjax' => true,
        'tableOptions' 	=> ['class' => 'table table-bordered tableSize'],
        'striped' => false,
        'rowOptions' => ['class' => 'trTable trNormal'],
        'columns' => [
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '1px',
                'enableRowClick' => true,
                'expandOneOnly' => true,
                'expandIcon' => '<span class="glyphicon glyphicon-chevron-right"></span>',
                'collapseIcon' => '<span class="glyphicon glyphicon-chevron-down"></span>',
                'detailUrl' => Url::to(['detail']),
                'value' => function(){
                    return GridView::ROW_COLLAPSED;
                },
                'contentOptions' => ['class' => 'border-left textTr', 'style' => 'border:none'],

            ],
            [
                'attribute' => 'id',
                'hAlign' => GridView::ALIGN_RIGHT,
                'contentOptions' => ['class' => 'textTr tr50', 'style' => 'border:none'],
            ],
            [
                'attribute' => 'date',
                'format' => ['date', 'php:d M H:i'],
                'hAlign' => GridView::ALIGN_RIGHT,
                'contentOptions' => ['class' => 'textTr srok tr90'],
            ],
            [
                'attribute' => 'commetnt',
                'format' => 'text',
                'contentOptions'=>['style'=>'white-space: normal;'],
            ],
//            [
//                'attribute' => 'declined',
//                'format' => 'raw',
//                'contentOptions' => ['class' => 'textTr tr20'],
//            ],
            [
                'attribute' => 'id_user',
                'value' => 'idUser.name',
                'contentOptions' => ['class' => 'textTr tr90'],
                'hAlign' => GridView::ALIGN_RIGHT,
                'visible' => Yii::$app->user->can('system'),
            ],
            [
                'attribute' => '',
                'format' => 'raw',
                'contentOptions' => ['class' => 'textTr tr90'],
                'value' => function($model){
                    return $model->status == Helpdesk::STATUS_CHECKING ? Html::a('Принять', ['approved', 'id' => $model->id]).''.Html::a('Отклонить', ['#'], ['class' => 'declinedHelp', 'value' => Url::to(['declined-help', 'id' => $model->id])]) : '';
                },
                'visible' => !Yii::$app->user->can('system')
            ],
            [
                'attribute' => 'sotrud',
                'contentOptions' => ['class' => 'textTr tr50'],
            ],
            [
                'attribute' => 'statusHelpName',
                'format' => 'raw',
                'contentOptions' => function($model){
                    if ($model->status == Helpdesk::STATUS_CHECKING){
                        return Yii::$app->user->can('system') ? ['class' => 'textTr successHelp tr90'] : ['class' => 'border-right successHelp textTr'];
                    } else {
                        return Yii::$app->user->can('system') ? ['class' => 'textTr tr90'] : ['class' => 'border-right textTr'];
                    }
                },
                'hAlign' => GridView::ALIGN_LEFT,
                'value' => function($model){
                    if ($model->status == Helpdesk::STATUS_DECLINED){
                        return Html::tag('span', Html::encode($model->statusHelpName), [
                            'title' => $model->declined,
                            'data-toggle' => 'popover',
                            'data-placement' => 'top',
                            'class' => 'declined',
                        ]);
                    } else {
                        return $model->statusHelpName;
                    }
                }
            ],
            [
                'attribute' => '',
                'format' => 'raw',
                'contentOptions' => ['class' => 'border-right textTr'],
                'value' => function() {
                    return '';
                },
                'visible' => Yii::$app->user->can('system')
            ],
        ],
    ]); ?>
    <?php $js = <<< 'SCRIPT'
/* To initialize BS3 popovers set this below */
$(function () { 
    $("[data-toggle='popover']").popover(); 
});
SCRIPT;
    // Register tooltip/popover initialization javascript
    $this->registerJs($js); ?>
</div>
<?php Pjax::end(); ?>
<?php Modal::begin([
    'id' => 'declinedHelpModal',
    'header' => '<h2>Укажите причину отказа:</h2>',
]);

echo '<div class="modalContent"></div>';

Modal::end();?>


