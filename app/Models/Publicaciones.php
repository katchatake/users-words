<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicaciones extends Model
{
    use HasFactory;
    protected $fillable = [
        'id','id_frase','id_user_admin','comentario','created_at'
    ];
    public function frases(){
        return $this->hasMany(Frases::class, 'id', 'id_user_admin');
    }
}
