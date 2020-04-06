<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gamme extends Model
{
    //
    protected $table='gammes';
    protected $primaryKey='gamme_id';

    public function specialites(){
        return $this->hasMany('App\Specialite','specialite_id ');
    }

    public function produits(){
        return $this->belongsToMany('App\Produit','produit_gammes','gamme_id','produit_id');
    }

    public function users(){
        return $this->belongsToMany('App\User','user_gammes','gamme_id','user_id');
    }

}
