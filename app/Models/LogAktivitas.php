<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    protected $table = 'log';
    protected $primaryKey = 'id_log';

    public $timestamps = false;
    // const CREATED_AT = 'create_at';
    // const UPDATED_AT = null;

    protected $fillable = [
        'id_user',
        'aktivitas',
        'target_tabel',
        'id_target',
        'create_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
