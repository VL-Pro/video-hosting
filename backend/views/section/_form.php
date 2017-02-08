<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Section */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="section-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([
            \common\models\Section::STATUS_ACTIVE => 'Active',
            \common\models\Section::STATUS_INV => 'Invisible',
            \common\models\Section::STATUS_DELETED => 'Deleted'])
    ?>
    <?php if($model->image) : ?>
        <div>
            <img src="<?= \common\models\Image::getImagesParentFolderLink().$model->image->path ?>">
        </div>
        <?= $form->field($model, 'imageFile')->fileInput(['accept' => 'image/*'])->label('Update Preview Image') ?>
    <?php else: ?>
        <?= $form->field($model, 'imageFile')->fileInput(['accept' => 'image/*'])->label('Choose Preview Image') ?>
    <?php endif; ?>

<!--    --><?//= $form->field($model, 'image_id')->textInput() ?>

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
