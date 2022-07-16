<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupoinf extends Model
{
    use HasFactory;
    protected $fillable = ['descripcion'];

    public static $rules = [
        'descripcion' => 'required|min:3',
    ];

    public static $customMessages = [
        'descripcion.required' => 'El campo descripcion es obligatorio.',
        'descripcion.min' => 'El campo descripción debe contener >3 caract'
    ];

    public function informatica()
    {
        return $this->belongsTo(Grupoinf::class);
    }
}
