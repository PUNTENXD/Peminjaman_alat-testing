<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';

    public $timestamps = true;
    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'nama_kategori'
    ];

    public function alat()
    {
        return $this->hasMany(Alat::class, 'id_kategori');
    }
}
