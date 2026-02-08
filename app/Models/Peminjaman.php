<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';

    public $timestamps = true;
    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'id_user',
        'id_alat',
        'jumlah',
        'tgl_pinjam',
        'tgl_rencana_kembali',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'id_alat');
    }

    public function kembali()
    {
        return $this->hasOne(Kembali::class, 'id_peminjaman');
    }
}
