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

    public function scopeWithAndWhereHas($query, $relation, $constraint){
        return $query->whereHas($relation, $constraint)
            ->with([$relation => $constraint]);
    }

    public function getEmailAttribute($value)
    {
        return strtolower($value);
    }
}
