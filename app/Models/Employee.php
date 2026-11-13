<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    // menggunakan properti fillable untuk menentukan field mana yang bisa diisi 
    protected $fillable = [
        'nama', 'nip', 'email', 'jabatan', 'alamat', 'foto'
    ];
}
