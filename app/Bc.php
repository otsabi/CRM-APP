<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bc extends Model
{
    protected $table='bcs';
    protected $primaryKey='bc_id';

    public function medecin(){
        return $this->belongsTo('App\Medecin', 'medecin_id');
    }

}


