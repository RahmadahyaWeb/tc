<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tr_progress_provider".
 *
 * @property string $resi
 * @property int $id_provider
 * @property string $no_invoice
 * @property int $nominal_tagihan
 * @property string|null $tanggal_pembuatan_invoice
 * @property string|null $tanggal_penerimaan_invoice
 * @property string|null $tanggal_verifikasi_validasi_invoice
 * @property string|null $tanggal_pembayaran_invoice
 * @property string $bukti_pembayaran
 *
 * @property MsProvider $provider
 */
class TrProgressProvider extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    // public $link_bukti_pembayaran;

    public static function tableName()
    {
        return 'tr_progress_provider';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['resi', 'id_provider', 'no_invoice', 'nominal_tagihan',], 'required'],
            [['id_provider', 'nominal_tagihan'], 'integer'],
            [['tanggal_pembuatan_invoice', 'tanggal_penerimaan_invoice', 'tanggal_verifikasi_validasi_invoice', 'tanggal_pembayaran_invoice', 'bukti_pembayaran'], 'safe'],
            [['resi'], 'string', 'max' => 50],
            [['no_invoice'], 'string', 'max' => 255],
            [['resi'], 'unique'],
            [['id_provider'], 'exist', 'skipOnError' => true, 'targetClass' => MsProvider::className(), 'targetAttribute' => ['id_provider' => 'id']],
            [['bukti_pembayaran'], 'file', 'skipOnEmpty' => TRUE, 'extensions' => 'pdf, jpg, png', 'maxSize' => 200 * 1024, 'tooBig' => 'Ukuran file tidak boleh lebih dari 200KB.'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'resi' => 'Resi',
            'id_provider' => 'Id Provider',
            'no_invoice' => 'No Invoice',
            'nominal_tagihan' => 'Nominal Tagihan',
            'tanggal_pembuatan_invoice' => 'Tanggal Pembuatan Invoice',
            'tanggal_penerimaan_invoice' => 'Tanggal Penerimaan Invoice',
            'tanggal_verifikasi_validasi_invoice' => 'Tanggal Verifikasi Validasi Invoice',
            'tanggal_pembayaran_invoice' => 'Tanggal Pembayaran Invoice',
            'bukti_pembayaran' => 'Bukti Pembayaran',
        ];
    }

    /**
     * Gets query for [[Provider]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProvider()
    {
        return $this->hasOne(MsProvider::className(), ['id' => 'id_provider']);
    }
}