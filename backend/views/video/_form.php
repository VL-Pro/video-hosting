<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Video */
/* @var $form yii\widgets\ActiveForm */



$script = <<< JS
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
        }

            reader.readAsDataURL(input.files[0]);
        }
    document.getElementById('blah' ).style.display = 'block';
    
}

$("#video-imagefile").change(function(){
    readURL(this);
});
JS;

$this->registerJs($script, yii\web\view::POS_READY);
?>

<div class="video-form">

    <?php $form = ActiveForm::begin(); ?>



    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<!--    --><?//= $form->field($model, 'path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'section')-> dropDownList(
        \yii\helpers\ArrayHelper::map(\common\models\Section::findAvailable()->all(), 'id', 'name'),
        ['prompt' => 'Select Section',
        'onchange'=>'$.post("/backend/video/lists?id='.'"+$(this).val(),
        function( data ) {
                  $( "select#video-topic_id" ).html( data );
                });'
        ]
    ) ?>

    <?php if($model->topic_id): ?>
        <?= $form->field($model, 'topic_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(\common\models\Topic::findAvailable()->all(), 'id', 'name')); ?>
    <?php else:?>
        <?= $form->field($model, 'topic_id')->dropDownList(
            //\yii\helpers\ArrayHelper::map(\common\models\Topic::getActive(), 'id', 'name'),
            [],
            ['prompt' => 'Select topic']
        ) ?>
    <?php endif; ?>


    <?php if($model->image) : ?>
        <div>
            <img id="blah" src="<?= \common\models\Image::getImagesParentFolderLink().$model->image->path ?>">
        </div>
        <?= $form->field($model, 'imageFile')->fileInput(['accept' => 'image/*'])->label('Update Preview Image') ?>
    <?php else: ?>
        <div>
            <img id="blah" src="#" style="display: none;">
        </div>
        <?= $form->field($model, 'imageFile')->fileInput(['accept' => 'image/*'])->label('Choose Preview Image') ?>
    <?php endif; ?>

    <?php if($model->image) : ?>
        <div>
            <img src="<?= \common\models\Image::getImagesParentFolderLink().$model->image->path ?>">
        </div>
        <?= $form->field($model, 'videoFile')->fileInput(['accept' => 'image/*'])->label('Update Video') ?>
    <?php else: ?>
        <?= $form->field($model, 'videoFile')->fileInput(['accept' => 'video/*'])->label('Choose Video') ?>
    <?php endif; ?>


<!---->
<!--    --><?//= $form->field($model, 'created_at')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'created_by')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'updated_at')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
