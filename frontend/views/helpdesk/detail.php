<?php
use kartik\form\ActiveForm;
use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: Rus
 * Date: 19.10.2017
 * Time: 11:17
 */
/** @var $model \app\models\Helpdesk */
/** @var $comment \app\models\Comment */
/** @var $commentForm \app\models\Comment */
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
            'action' => ['comment/helpdesk', 'id' => $model->id]
        ]) ?>

        <?= $form->field($commentForm, 'comment')->textarea(['rows' => 1])->label(false) ?>

        <?= Html::submitButton('Коммент', ['class' => 'btn btn-primary']) ?>

        <?php ActiveForm::end() ?>
    <?php endif; ?>
</div>
