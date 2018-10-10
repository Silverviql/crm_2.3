<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Partners */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Partners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partners-view">

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn action']) ?>
    </p>

    <div class="col-lg-8">
        <?= DetailView::widget([
            'model' => $model,
            'bordered' => false,
            'striped' => false,
            'attributes' => [
                [
                    'group' => true,
                    'label' => 'Местоположение',
                    'groupOptions' => ['style' => 'border-top: none']
                ],
                [
                    'columns' => [
                        [
                            'attribute' => 'address',
                            'labelColOptions' => ['style' => 'width: 10px']
                        ],
                        [
                            'attribute' => 'room',
                            'labelColOptions' => ['style' => 'width: 10px']
                        ],
                        [
                            'attribute' => 'web',
                            'format' => 'raw',
                            'value' => Html::a($model->web, $model->web, ['target' => '_blank']),
                            'labelColOptions' => ['style' => 'with: 10px']
                        ]
                    ],
                ],
                [
                    'group' => true,
                    'label' => 'Контакты',
                ],
                [
                    'columns' => [
                        'phone',
                        'email:email',
                        'contact_person',
                    ]
                ],
                'specialization',
            ],
        ]) ?>
    </div>

</div>
