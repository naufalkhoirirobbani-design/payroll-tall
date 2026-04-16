<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class karyawan extends Model
{
    protected $table = 'karyaman';

    protected $guarded = ['id'];

    public function departemen()
    {
        return $this->belongsTo(departemen::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function penggajian()
    {
        return $this->belongsTo(penggajihan::class);
    }
}
