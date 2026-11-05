<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    protected $table = 'reservasis';

    protected $fillable = [
        'nama_pelanggan',
        'nomor_reservasi',
        'no_hp',
        'meja_id',
        'jumlah_orang',
        'tanggal_reservasi',
        'jam_reservasi',
        'status',
        'keterangan',
        'metode_pembayaran',
        'total_bayar',
        'uang_dibayar',
        'kembalian',
    ];

    protected $casts = [
        'tanggal_reservasi' => 'date',
    ];

    /**
     * Relasi ke meja
     */
    public function meja()
    {
        return $this->belongsTo(Meja::class);
    }
}