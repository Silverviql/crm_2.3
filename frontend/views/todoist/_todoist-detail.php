<?php

use app\models\User;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $model app\models\Todoist */
/* @var $comment app\models\Comment */
/* @var $commentForm app\models\Comment */


?>
<div>
    <h3><?= Html::encode('Комментарии') ?>
        <script>
            $(document).ready(function () {
                $(function () {
                    $('[data-toggle = "tooltip"]').tooltip();
                });
            })
        </script>
            <?= Html::tag('span', '', [
                'id' => 'help',
                'class' => 'glyphicon glyphicon-exclamation-sign',
                'title' => 'Выводится только последние 3 комментарии',
                'data-toggle' => 'tooltip',
                'style' => 'font-size: 14px;cursor:pointer;',
            ]) ?>
    </h3>
</div>
<div class="col-lg-6">
    <?php if ($comment != null){
        foreach ($comment as $commen){
            echo '<div style="float: left">'.date('d.m.Y', strtotime($commen->date)).'</div>
                  <div style="padding-left: 8px;word-break: break-all; width: 339px;float: left;">'.$commen->comment.'</div>
                  <div style="float: right">'.$commen->idUser->name.'</div><br>';
        }
    } else {
        echo 'Комментариев пока что нет';
    } ?>
    <?php if (!Yii::$app->user->can('manager')): ?>
    <?php $form = ActiveForm::begin([
            'action' => ['comment/todoist', 'id' => $model->id]
    ]) ?>

    <?= $form->field($commentForm, 'comment')->textarea(['rows' => 1])->label(false) ?>

    <?= Html::submitButton('Коммент', ['class' => 'btn btn-primary']) ?>

    <?php ActiveForm::end() ?>
    <?php endif; ?>
</div>

<div class="col-lg-6">
    <div>
        <?= Html::encode('Создан '.Yii::$app->formatter->asDatetime($model->date, 'php:d M Y H:i')) ?>
        <?php echo $model->img != null
            ? 'Файл: '.Html::a('<span class="glyphicon glyphicon-paperclip"></span>', '@web/'.$model->img, [
                'download' => true,
                'data-pjax' => 0,
                'title' => 'Чтобы скачать приложение кликните на ссылку',
                'data-toggle' => 'tooltip'
            ])
            : false ?>
    </div>
    <?php if (!Yii::$app->user->can('manager')): ?>
    <?= Html::checkbox('appoint', false, ['label' => 'Переназначить', 'class' => 'icheckbox', 'id' => 'checkboxAppoint']) ?>

    <div class="form-appoint">
        <?php $form = ActiveForm::begin([
                'action' => ['todoist/appoint', 'id' => $model->id]
        ]) ?>

        <?= $form->field($model, 'id_user')->dropDownList(ArrayHelper::map(User::find()->select(['id', 'name'])->indexBy('id')->all(), 'id', 'name'))->label(false) ?>

        <?= Html::submitButton('Назначить', ['class' => 'btn action']) ?>

        <?php ActiveForm::end() ?>
    </div>
    <?php endif; ?>
</div>
