<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pharmacie extends Model
{
    //
    protected $table='pharmacies';
    protected $primaryKey='pharmacie_id';

    protected $casts = [
        'valid' => 'boolean',
    ];

    public function ville(){
        return $this->belongsTo('App\Ville','ville_id');
    }

    public function visites(){
        return $this->hasMany('App\VisitePharmacie','pharmacie_id');
    }


}
