<?php

use app\models\User;

switch ($model->id_user){
        case Yii::$app->user->id;
            $user = 'Я';
            break;
        case (User::USER_DISAYNER);
            $user = 'Дизайнер';
            break;
        case (User::USER_MASTER):
            $user = 'Мастер';
            break;
    }
    echo  '
        <div style="display: block;">
            <div class="userCommit">'.$user.':</div>
            <div class="comment">'.$model->comment.'</div>
            <div class="dateCommit">'.date('d.m H:i', strtotime($model->date)).'</div>
        </div>';
?>