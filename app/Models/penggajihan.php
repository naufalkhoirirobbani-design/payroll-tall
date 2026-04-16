<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class penggajihan extends Model
{
    protected $table = 'penggajian';

    protected $guarded = ['id'];

    public function karyaman()
    {
        return $this->belongsTo(karyawan::class);
    }
}
