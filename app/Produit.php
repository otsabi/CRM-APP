<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Produit extends Model
{
    //
    protected $table='produits';
    protected $primaryKey='produit_id';

    public function gammes(){
        return $this->belongsToMany('App\Gamme','produit_gammes','produit_id','gamme_id');
    }

    public function scopeOfGammes($query,$gammes = array()){
            return $query->whereHas('gammes',function (Builder $bld) use ($gammes){
                $bld->whereIn('gammes.gamme_id',$gammes);
            });
    }

}
