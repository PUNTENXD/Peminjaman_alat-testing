<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';

    public $timestamps = true;
    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'update_at';

    protected $fillable = [
        'id_user',
        'id_alat',
        'jumlah',
        'tgl_pinjam',
        'tgl_rencana_kembali',
        'tgl_kembali',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function alat()
    {
          return $this->belongsTo(Alat::class,'id_alat','id_alat');
    }

protected $casts = [
    'tgl_pinjam' => 'datetime',
    'tgl_kembali' => 'datetime',
    'tgl_rencana_kembali' => 'date',
    'create_at' => 'datetime',
];


protected $dates = [
    'tgl_pinjam',
    'tgl_kembali',
    'create_at',
];




    // Hitung hari terlambat
public function getHariTerlambatAttribute()
{
    if (!$this->tgl_rencana_kembali) {
        return 0;
    }

    $rencana = Carbon::parse($this->tgl_rencana_kembali)->startOfDay();

    // Kalau masih dipinjam
    if ($this->status == 'pinjam') {
        $today = Carbon::now()->startOfDay();

        if ($today->gt($rencana)) {
            return $rencana->diffInDays($today);
        }
    }

    // Kalau sudah kembali
    if ($this->status == 'kembali' && $this->tgl_kembali) {
        $kembali = Carbon::parse($this->tgl_kembali)->startOfDay();

        if ($kembali->gt($rencana)) {
            return $rencana->diffInDays($kembali);
        }
    }

    return 0;
}


// Hitung denda (2000 / hari)
public function getDendaAttribute()
{
    return $this->hari_terlambat * 2000;
}

// Status terlambat
public function getStatusTerlambatAttribute()
{
    return $this->hari_terlambat > 0;
}

    
}
