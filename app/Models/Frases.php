<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Frases extends Model
{
    use HasFactory;
    protected $fillable = [
        'id','id_user_invite','texto', 'status','created_at'
    ];
    public function users(){
        return $this->hasMany(Users::class, 'id', 'id_user_invite');
    }
    public function comments(){
        return $this->hasMany(Publicaciones::class, 'id_frase', 'id');
    }
}
