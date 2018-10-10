<?php

use frontend\components\NavKnowledge;

$this->title = $model->title;
?>

<div class="site-post">
    <div class="col-lg-3">
        <?php echo NavKnowledge::widget() ?>
    </div>
    <div class="col-lg-9">
        <h2><?php echo $model->title ?></h2>
        <?php if ($model->video != null ) {
            echo '<iframe width="560" height="315" src='.$model->video.' frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
        } else {
            echo '';
        } ?>
        <div><?php echo $model->text ?></div>
    </div>
</div>
