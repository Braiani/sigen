<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Falta extends Model
{
    public function aluno()
    {
        return $this->belongsTo('App\Aluno');
    }
}
