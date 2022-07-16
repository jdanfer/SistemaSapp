<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informatica extends Model
{
    use HasFactory;
    protected $fillable = ['descripcion', 'grupoinf_id', 'base', 'user_id'];

    public static $rules = [
        'descripcion' => 'required|min:3',
    ];

    public static $customMessages = [
        'descripcion.required' => 'El campo descripcion es obligatorio.',
        'descripcion.min' => 'El campo descripción debe contener >3 caract'
    ];

    public function grupoinf()
    {
        return $this->belongsTo('App\Models\Grupoinf');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
