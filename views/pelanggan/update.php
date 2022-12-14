<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pelanggan */

$this->title = 'Update Pelanggan: ' . $model->pelanggan_id;
$this->params['breadcrumbs'][] = ['label' => 'Pelanggan', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->pelanggan_id, 'url' => ['view', 'pelanggan_id' => $model->pelanggan_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pelanggan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>