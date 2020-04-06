<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Secteur extends Model
{
    //
    protected $table='secteurs';
    protected $primaryKey='secteur_id';

    public function villes(){
        return $this->hasMany('App\Ville','secteur_id');
    }


    public function medecins(){
        return $this->hasManyThrough(
            'App\Medecin',
            'App\Ville',
            'secteur_id', // cle etrangere sur la table ville
            'ville_id', // cle etrangere sur la table medecins
            'secteur_id', // cle primaire sur la table secteurs
            'ville_id' // cle primaire sur la table villes
        );
    }

    public function users(){
        return $this->hasManyThrough(
            'App\User',
            'App\Ville',
            'secteur_id', // cle etrangere sur la table ville
            'ville_id', // cle etrangere sur la table users
            'secteur_id', // cle primaire sur la table secteurs
            'ville_id' // cle primaire sur la table villes
        )->nonAdmin();
    }

    public function pharmacies(){
        return $this->hasManyThrough(
            'App\Pharmacie',
            'App\Ville',
            'secteur_id', // cle etrangere sur la table ville
            'ville_id', // cle etrangere sur la table phamacies
            'secteur_id', // cle primaire sur la table secteurs
            'ville_id' // cle primaire sur la table villes
        );
    }
}
