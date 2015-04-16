<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Oauthclient */

$this->title = 'Update Oauthclient: ' . ' ' . $model->client_id;
$this->params['breadcrumbs'][] = ['label' => 'Oauthclients', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->client_id, 'url' => ['view', 'id' => $model->client_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="oauthclient-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
