<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class departemen extends Model
{
    protected $table = 'departemen';

    //mengizinkan mass-assigment
    protected $fillable =['kode', 'nama'];

    /*
    * Relasi One-to-many: 1 Departemen bisa punya banyak jabatan
    */

    public function jabatan()
    {
        return $this->hasMany(jabatan::class);
    }
}
