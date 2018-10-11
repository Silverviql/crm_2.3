<?php

use app\models\Courier;
use app\models\Helpdesk;
use app\models\Todoist;
use app\models\Zakaz;
use kartik\grid\GridView;
use yii\helpers\Html;
use dosamigos\chartjs\ChartJs;
use yii\helpers\StringHelper;
use yii\helpers\Url;

$this->title = 'Управляющий';
?>

<div class="manager-index">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-3">
                <h2><?=Html::encode('Админ') ?></h2>
                <p>
                    <?= Html::a('Админ', ['/zakaz/admin'], ['class' => 'btn btn-success']) ?>
                </p>
            </div>

            <div class="col-lg-3">
                <h2><?=Html::encode('Дизайнер') ?></h2>
                <p>
                    <?= Html::a('Дизайнер', ['/zakaz/design'], ['class' => 'btn btn-success']) ?>
                </p>
            </div>

            <div class="col-lg-3">
                <h2><?= Html::encode('Мастер') ?></h2>
                <p>
                    <?= Html::a('Мастер', ['/zakaz/master'], ['class' => 'btn btn-success']) ?>
                </p>
            </div>
                <div class="col-lg-3">
                    <h2><?= Html::encode('Курьер') ?></h2>
                    <p>
                        <?= Html::a('Курьер', ['/courier/shipping'], ['class' => 'btn btn-success']) ?>
                    </p>
                </div>
             </div>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-3">
                <h2><?=Html::encode('Сиб') ?></h2>
                <p>
                    <?= Html::a('Сиб', ['/zakaz/manager', 'id' => 9], ['class' => 'btn btn-success']) ?>
                </p>
            </div>

            <div class="col-lg-3">
                <h2><?=Html::encode('Мск') ?></h2>
                <p>
                    <?= Html::a('Мск', ['/zakaz/manager', 'id' => 2], ['class' => 'btn btn-success']) ?>
                </p>
            </div>

            <div class="col-lg-3">
                <h2><?= Html::encode('Маркс') ?></h2>
                <p>
                    <?= Html::a('Маркс', ['/zakaz/manager', 'id' => 16], ['class' => 'btn btn-success']) ?>
                </p>
            </div>
            <div class="col-lg-3">
                <h2><?= Html::encode('Пушк') ?></h2>
                <p>
                    <?= Html::a('Пушк', ['/zakaz/manager', 'id' => 6], ['class' => 'btn btn-success']) ?>
                </p>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-3">
                <h2><?=Html::encode('Чет') ?></h2>
                <p>
                    <?= Html::a('Чет', ['/zakaz/manager', 'id' => 12], ['class' => 'btn btn-success']) ?>
                </p>
            </div>
             <div class="col-lg-3">
                <h2><?=Html::encode('Калин') ?></h2>
                <p>
                    <?= Html::a('Калин', ['/zakaz/manager', 'id' => 17], ['class' => 'btn btn-success']) ?>
                </p>
            </div>
            <div class="col-lg-3">
                <h2><?=Html::encode('Архив') ?></h2>
                <p>
                    <?= Html::a('Архив', ['/zakaz/archive'], ['class' => 'btn btn-success']) ?>
                </p>
            </div>
        </div>
    </div>
</div>