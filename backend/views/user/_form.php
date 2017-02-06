<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'role')->dropDownList([
        \common\models\User::ROLE_USER => 'User',
        \common\models\User::ROLE_ADMIN => 'Admin',
    ]) ?>
    <?= $form->field($model, 'status')->dropDownList([
        \common\models\User::STATUS_ACTIVE => 'Active',
        \common\models\User::STATUS_DELETED => 'Deleted',
    ]) ?>
    <?= $form->field($model, 'section')->widget(\kartik\select2\Select2::className(), [
        'data' => \yii\helpers\ArrayHelper::map(\common\models\Section::getActive(), 'id', 'name'),
        'options' => [
            'placeholder' => 'Select Sections...',
            'multiple' => true,
        ],
        'pluginOptions' => [
            'tags' => true,
            'allowClear' => true,
        ],
    ]); ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
