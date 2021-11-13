<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fatih extends Model
{
    use HasFactory;
    protected $table="fatih";
    protected $fillable=["id","baslik","selflink","kategori","resim","metin","anahtar","description","durum","sirano","created_at","updated_at"];
}