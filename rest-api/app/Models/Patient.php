<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'patients';

    // Kolom yang dapat diisi secara massal
    protected $fillable = ['name', 'dob', 'gender', 'address', 'phone_number'];
}
