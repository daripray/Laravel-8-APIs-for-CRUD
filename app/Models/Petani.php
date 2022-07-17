<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Petani extends Model
{
    use HasFactory;
    protected $table = 'petanis';
    protected $fillable = ['kelompok_tani_id', 'nik', 'name', 'alamat', 'telp', 'foto', 'status'];

    public function Group()
    {
        return $this->belongsTo(Group::class);
    }
}
