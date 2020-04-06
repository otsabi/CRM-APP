<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialite extends Model
{
    //
    protected $table='specialites';
    protected $primaryKey='specialite_id';

    public function gamme(){
        return $this->belongsTo('App\Gamme','gamme_id');
    }

    public function visites(){
        return $this->hasManyThrough(
            'App\VisiteMedical', // the final table we want to access
            'App\Medecin', // the intermediate model
            'specialite_id',// the foreign key on the intermediate model
            'medecin_id',// the name of the foreign key on the final model
            'specialite_id', // local primary key
            'medecin_id' // the local key of the intermediate model
        );
    }
}
