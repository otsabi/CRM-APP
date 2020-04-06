<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VisitePharmacie extends Model
{
    //

    protected $table='visite_pharmacies';
    protected $primaryKey='visitephar_id';

    public function products(){
        return $this->belongsToMany('App\Produit','vph_produits','visitephar_id', 'produit_id')
            ->withPivot('nb_boites');
    }

    public function pharmacie(){
        return $this->belongsTo('App\Pharmacie','pharmacie_id');
    }

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
}
