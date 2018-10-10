<?php
use kartik\file\FileInput;
use kartik\form\ActiveForm;
use kartik\helpers\Html;
?>

<div class="zakaz-upload">
    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'file')->widget(FileInput::className(), [
        'language' => 'ru',
        'options' => ['multiple' => false],
        'pluginOptions' => [
            'theme' => 'explorer',
            'showCaption' => false,
            'showRemove' => false,
            'showUpload' => false,
            'showPreview' => true,
            'browseClass' => 'action fileInput',
            'previewFileType' => 'any',
            'maxFileCount' => 1,
            'maxFileSize' => 25600,
            'preferIconicPreview' => true,
            'previewFileIconSettings' => ([
                'doc' => '<i class="fa fa-file-word-o text-orange"></i>',
                'xls' => '<i class="fa fa-file-excel-o text-orange"></i>',
                'ppt' => '<i class="fa fa-file-powerpoint-o text-orange"></i>',
                'pdf' => '<i class="fa fa-file-pdf-o text-orange"></i>',
                'zip' => '<i class="fa fa-file-archive-o text-orange"></i>',
                'rar' => '<i class="fa fa-file-archive-o text-orange"></i>',
                'txt' => '<i class="fa fa-file-text-o text-orange"></i>',
                'jpg' => '<i class="fa fa-file-photo-o text-orange"></i>',
                'png' => '<i class="fa fa-file-photo-o text-orange"></i>',
                'gif' => '<i class="fa fa-file-photo-o text-orange"></i>',
                'cdr' => '<i class="fa fa-file-photo-o text-orange"></i>',
            ]),
            'layoutTemplates' => [
                'preview' => '<div class="file-preview {class}">
                               <div class="{dropClass}">
                               <div class="file-preview-thumbnails">
                                </div>
                                <div class="clearfix"></div>
                                <div class="file-preview-status text-center text-success"></div>
                                <div class="kv-fileinput-error"></div>
                                </div>
                                </div>',
                'actionDrag' => '<span class="file-drag-handle {dragClass}" title="{dragTitle}">{dragIcon}</span>',
            ],
        ]
    ])->label(false) ?>

    <?= Html::submitButton('Выполнить работу', ['class' => 'action submitFile']) ?>

    <?php ActiveForm::end() ?>
</div>
