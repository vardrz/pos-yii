<?php

use yii\helpers\VarDumper;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use app\models\Barang;
use app\models\PenjualanDetail;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\PenjualanDetail */
/* @var $form ActiveForm */
?>
<div class="penjualan-form_detail">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nomor_nota') ?>
    <?= $form->field($model, 'barang_id')->label('Pilih Barang')->dropDownList(ArrayHelper::map(Barang::find()->all(), 'barang_id', 'nama_barang'), ['prompt' => '-- Pilih --']) ?>
    <?php Pjax::begin(['id' => 'pjax-harga']) ?>
    <?php
    $harga = '';
    $barang_id = isset($_COOKIE['barang_id']) ? $_COOKIE['barang_id'] : '';
    $x = Barang::findOne($barang_id);
    $harga = isset($x) ? $x->harga_satuan : '';
    ?>
    <?= $form->field($model, 'harga')->textInput(['value' => $harga]) ?>
    <?php Pjax::end() ?>
    <?= $form->field($model, 'jumlah') ?>

    <div class="form-group">
        <?= Html::submitButton('Tambah', ['class' => 'btn btn-primary mb-5']) ?>
    </div>
    <?php ActiveForm::end(); ?>

    <?php
    $dataProvider = new ActiveDataProvider(['query' => PenjualanDetail::find()->where(['nomor_nota' => Yii::$app->session->get('nomor_nota')])]);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'barang.nama_barang',
            'harga:currency',
            'jumlah',
            'subtotal:currency',
            [
                'attribute' => 'Aksi',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a(Html::encode("Hapus"), ['delete', 'penjualan_detail_id' => $model->penjualan_detail_id]);
                },
            ],
        ]
    ])
    ?>

    <h4>Total Bayar : <?= Yii::$app->formatter->asCurrency(PenjualanDetail::find()->where(['nomor_nota' => Yii::$app->session->get('nomor_nota')])->sum('subtotal')) ?></h4>
    <!-- <a class="btn btn-primary mb-5" href="penjualan/print-nota&nomor_nota=<?= $model->nomor_nota; ?>" role="button">Cetak Nota</a> -->
    <?= Html::a(Html::encode("Cetak Nota"), ['print-nota', 'nomor_nota' => $model->nomor_nota], ['class' => 'btn btn-primary mb-3']); ?>

</div><!-- penjualan-form_detail -->

<?php
$js = <<<JS
        $("#penjualandetail-barang_id").change(function(){
            document.cookie = "barang_id="+this.value+"SameSite=Lax";
            console.log(this.value);
            $.pjax.reload({container: "#pjax-harga", async: true})
        });
    JS;
$this->registerJs($js);
?>