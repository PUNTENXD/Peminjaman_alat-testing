<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'log';
    protected $primaryKey = 'id_log';

    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'aktivitas',
        'target_tabel',
        'id_target',
        'create'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
