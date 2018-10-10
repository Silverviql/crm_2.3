<?php

use yii\helpers\Html;
$write = $model[0];
$lenght = count($model);
?>

<div class="test-testing">
    <h1><?= Html::encode($write->idThemeQuestion->name)?></h1>
    <?php echo Html::beginForm(['test/testing', 'id' => $write->id_theme], 'post') ?>
        <?php foreach ($model as $count => $question){
            $count = $count+1;
            echo '<div class="test-block">';
            echo 'Вопрос '.$count .'/'.$lenght.'<br>';
            echo $question->name.'<br/>';
            foreach ($question->answear as $key => $answear){
                echo Html::radio('Answear['.$question->id.']', false, ['label' => $answear, 'required' => true, 'value' => $answear]) . '<br/>';
            }
            if ($count != $lenght){
                echo Html::submitButton('Ответить', ['class' => 'btn btn-primary nextTest']).'<br/>';
            } else {
                echo Html::submitButton('Ответить', ['class' => 'btn btn-primary']).'<br/>';
            }
            echo '</div>';
        } ?>
    <?php echo Html::endForm() ?>

</div>
