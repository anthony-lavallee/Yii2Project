<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Oauthclient */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oauthclient-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'client_id')->textInput(['maxlength' => 32]) ?>

    <?= $form->field($model, 'client_secret')->textInput(['maxlength' => 32]) ?>

    <?= $form->field($model, 'redirect_uri')->textInput(['maxlength' => 1000]) ?>

    <?= $form->field($model, 'grant_types')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'scope')->textInput(['maxlength' => 2000]) ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
