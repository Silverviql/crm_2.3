<?php

use kartik\file\FileInput;
use yii\bootstrap\Html;
?>

<?= Html::beginForm(['test/create'], 'post', ['enctype' => 'multipart/form-data']); ?>
        <?php if ($thema != null){
            echo Html::hiddenInput('Thema', $thema->id);
        } else {
            echo '<div><label>Название темы</label>';
            echo Html::input('text', 'Thema', null, ['required' => true]).'</div>';
        } ?>
    <div>
        <label>Вопрос</label>
        <?= Html::input('text', 'Question', null, ['required' => true]) ?>
    </div>
    <div>
        <label>Ответ 1</label>
        <?= Html::input('text', 'Answer[1]', null, ['required' => true, 'class' => 'answer-1']) ?>
        <label><input type="radio" name="right" class="radio radio-1"><span>Правильный</span></label>
    </div>
    <div>
        <label>Ответ 2</label>
        <?= Html::input('text', 'Answer[2]', null, ['required' => true, 'class' => 'answer-2']) ?>
        <label><input type="radio" name="right" class="radio radio-2"><span>Правильный</span></label>
    </div>
    <div>
        <label>Ответ 3</label>
        <?= Html::input('text', 'Answer[3]', null, ['required' => true, 'class' => 'answer-3']) ?>
        <label><input type="radio" name="right" class="radio radio-3"><span>Правильный</span></label>
    </div>
    <div>
        <label>Ответ 4</label>
        <?= Html::input('text', 'Answer[4]', null, ['required' => true, 'class' => 'answer-4']) ?>
        <label><input type="radio" name="right" class="radio radio-4"><span>Правильный</span></label>
    </div>
    <div>
        <?php echo FileInput::widget([
            'name' => 'attachment[]',
            'options' => ['multiple' => true],
            'pluginOptions' => [
                'showUpload' => false,
                'maxFileCount' => 4,
                'maxFileSize' => 25600
            ]
        ]) ?>
    </div>
    <?= Html::submitButton('Создать', ['class' => 'btn btn-primary']); ?>
<?= Html::endForm(); ?>

<!--<div class="test-create">-->
<!--    <h1>--><?//= Html::encode($this->title) ?><!--</h1>-->
<!--    --><?//= Html::beginForm(['test/create'],'post') ?>
<!--        <div class="test-create_question">-->
<!--            <div class="test-create-question_page">-->
<!--                <label for="question">Вопрос 1</label>-->
<!--                --><?//= Html::input('text', 'Question[1]', null, ['id' => 'question']) ?>
<!--            </div>-->
<!--            <div>-->
<!--                <label for="answer-1">Ответ 1</label>-->
<!--                --><?//= Html::input('text', 'Answer[1]', null, ['id' => 'answer-1']) ?>
<!--            </div>-->
<!--            <div>-->
<!--                <label for="answer-2">Ответ 2</label>-->
<!--                --><?//= Html::input('text', 'Answer[2]', null, ['id' => 'answer-2']) ?>
<!--            </div>-->
<!--            <div>-->
<!--                <label for="answer-3">Ответ 3</label>-->
<!--                --><?//= Html::input('text', 'Answer[3]', null, ['id' => 'answer-3']) ?>
<!--            </div>-->
<!--            <div>-->
<!--                <label for="answer-4">Ответ 4</label>-->
<!--                --><?//= Html::input('text', 'Answer[4]', null, ['id' => 'answer-4']) ?>
<!--            </div>-->
<!--        </div>-->
<!--        --><?//= Html::button('Добавить вопрос', ['class' => 'btn btn-success addQuestion']) ?>
<!--        --><?//= Html::submitButton('Создать', ['class' => 'btn btn-primary']) ?>
<!--    --><?//= Html::endForm() ?>
<!--</div>-->