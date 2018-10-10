<?php

use yii\helpers\Html;

echo '<h1>'.$message.'</h1>';
echo '<h3> Правильных ответов '.$right.' из 15 вопросов</h3>';
echo Html::a('Вернуться на главную страницу', ['site/index'], ['class' => 'btn btn-primary']);
?>

