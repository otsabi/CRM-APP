<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    //
    protected $table='villes';
    protected $primaryKey='ville_id';

    public function secteur(){
        return $this->belongsTo('App\Secteur','secteur_id');
    }

    public function users(){
        return $this->hasMany('App\User','ville_id')->nonAdmin();
    }

    public function visitesMedicals(){
        return $this->hasManyThrough(
            'App\VisiteMedical',
            'App\Medecin',
            'ville_id', // cle etrangere sur la table medecin
            'medecin_id', // cle etrangere sur la table visites
            'ville_id', // cle primaire sur la table villes
            'medecin_id' // cle primaire sur la table medecins
        );
    }





}
