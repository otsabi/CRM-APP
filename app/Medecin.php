<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Medecin extends Model
{
    //
    protected $table='medecins';
    protected $primaryKey='medecin_id';

    protected $casts = [
        'valid' => 'boolean',
    ];

    public function ville(){
        return $this->belongsTo('App\Ville','ville_id');
    }

    public function specialite(){
        return $this->belongsTo('App\Specialite','specialite_id');
    }

    public function visites(){
        return $this->hasMany('App\VisiteMedical','medecin_id');
    }

    public function bc(){
        return $this->hasMany('App\Bc','bc_id');

    }
    
}
