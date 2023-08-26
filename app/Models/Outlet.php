<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Outlet extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nama_ot',
        'alamat_ot',
        'kontak_ot',
        'keterangan',
        'latitude',
        'longitude',
    ];
    /**
     * Get the employees for the Outlet
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function employees() : HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
