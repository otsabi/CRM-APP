<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VisiteMedical extends Model
{
    //
    protected $table='visite_medicals';
    protected $primaryKey='visitemed_id';

    protected $casts = [
        'date_visite' => 'date:Y-m-d',
        'valid' => 'boolean',
    ];

    public function products(){
        return $this->belongsToMany('App\Produit','vmed_produits','visitemed_id', 'produit_id')
                    ->using('App\VmedProduit')
                    ->withPivot('feedback_id','nbr_ech');
    }

    public function medecin(){
        return $this->belongsTo('App\Medecin','medecin_id');
    }


    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
}
