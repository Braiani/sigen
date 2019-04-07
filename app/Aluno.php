<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{

    protected $fillable = ['nome', 'curso_id', 'email'];

    public function curso()
    {
        return $this->belongsTo('App\Curso');
    }

    public function faltas()
    {
        return $this->hasMany('App\Falta');
    }
}
