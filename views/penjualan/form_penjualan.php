<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Penjualan */
/* @var $form ActiveForm */
?>
<div class="penjualan-form_penjualan">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'nomor_nota') ?>
        <?= $form->field($model, 'tanggal') ?>
        <?= $form->field($model, 'pelanggan_id') ?>
        <?= $form->field($model, 'total') ?>
        <?= $form->field($model, 'user_id') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- penjualan-form_penjualan -->
