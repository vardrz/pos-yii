<?php

namespace app\controllers;

use app\models\Penjualan;
use app\models\Pelanggan;
use app\models\PenjualanDetail;
use Yii;

class PenjualanController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new Penjualan();
        $model->total = 0;
        $model->user_id = 1;
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->set('nomor_nota', $model->nomor_nota);
                return $this->redirect(['input-barang']);
            }
        } else {
            $model->loadDefaultValues();
        }
        return $this->render('form_header', compact('model'));
    }

    public function actionInputBarang()
    {
        $model = new PenjualanDetail();
        $model->nomor_nota = Yii::$app->session->get('nomor_nota');
        $model->subtotal = 0;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->subtotal = $model->jumlah * $model->harga;
                $model->save();
                return $this->redirect(['input-barang']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('form_detail', compact('model'));
    }

    public function actionDelete($penjualan_detail_id)
    {
        echo $penjualan_detail_id;
        die();

        $data = PenjualanDetail::findOne($penjualan_detail_id);
        $data->delete();

        return $this->redirect(['input-barang']);
    }

    public function actionPrintNota($nomor_nota)
    {
        $this->layout = false;

        $nota = $nomor_nota;

        $tanggal = Penjualan::find()->where(['nomor_nota' => $nota])->one()->tanggal;
        $pelanggan_id = Penjualan::find()->where(['nomor_nota' => $nota])->one()->pelanggan_id;
        $pelanggan = Pelanggan::find()->where(['pelanggan_id' => $pelanggan_id])->one()->nama_pelanggan;

        return $this->render('print', compact('nota', 'pelanggan', 'tanggal'));
    }
}
