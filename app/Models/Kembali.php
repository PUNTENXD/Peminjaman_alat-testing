<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kembali extends Model
{
    protected $table = 'kembali';
    protected $primaryKey = 'id_kembali';

    public $timestamps = true;
    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'id_peminjaman',
        'tgl_kembali',
        'terlambat_hari',
        'keterangan'
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman');
    }
}
