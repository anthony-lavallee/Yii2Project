<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Oauthuser */

$this->title = 'Update Oauthuser: ' . ' ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Oauthusers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->username]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="oauthuser-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
