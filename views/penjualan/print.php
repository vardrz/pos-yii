<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style type="text/css" media="print">
        @page {
            size: auto;
            margin: 0 50px;
        }

        .w300 {
            width: 30%;
        }
    </style>
</head>

<?php

use app\models\PenjualanDetail;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
?>

<center>
    <h3 style="margin-top: 50px;">VARD COMPUTER</h3>
    <h6 style="margin-bottom: 30px;">Jln. Ahmad Yani No. 102 &nbsp; &nbsp; WA: 08150021000
        <br />Wiradesa, Kab. Pekalongan
    </h6>

    <table width="100%" style="margin-bottom:20px">
        <tr>
            <td>Nomor Nota</td>
            <td>:</td>
            <td><?= $nota; ?></td>
            <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
            <td>Kepada Yth</td>
            <td>:</td>
            <td><?= $pelanggan; ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Tanggal Nota</td>
            <td>:</td>
            <td><?= $tanggal; ?></td>
        </tr>
    </table>

    <?php
    $dataProvider = new ActiveDataProvider(['query' => PenjualanDetail::find()->where(['nomor_nota' => $nota])]);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'columns' => [
            'barang.nama_barang',
            [
                'label' => 'Harga',
                'attribute' => 'harga',
                'format' => 'currency',
                'enableSorting' => false
            ],
            [
                'label' => 'Jumlah',
                'attribute' => 'jumlah',
                'format' => 'text',
                'enableSorting' => false
            ],
            [
                'label' => 'Subtotal',
                'contentOptions' => ['class' => 'w300'],
                'attribute' => 'subtotal',
                'format' => 'currency',
                'enableSorting' => false
            ]
        ]
    ])
    ?>
    <table class="table table-striped table-bordered">
        <tr>
            <td colspan="3"><b>Total Bayar :</b></td>
            <td width='30%'>
                <b><?= Yii::$app->formatter->asCurrency(PenjualanDetail::find()->where(['nomor_nota' => $nota])->sum('subtotal')) ?></b>
            </td>
        </tr>
    </table>

    <table width="90%" style="margin-top:20px">
        <tr valign="top">
            <td><b style="margin-right: 20px;">NB:</b></td>
            <td>Barang yang sudah dibeli tidak bisa ditukar. harap periksa kembali barang belanjaan anda!</td>
            <td width="40%" align="center">
                Hormat Kami
                <br><br><br><br>
                <br>Vard Computer
            </td>
        </tr>
    </table>

</center>

<script>
    window.print();
</script>