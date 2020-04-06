<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class VmedProduit extends Pivot
{
    //
    protected $table='vmed_produits';
    protected $primaryKey='pp_vsm_id';
    public $incrementing = true;

    public function feedback(){
        return $this->belongsTo('App\Feedback','feedback_id');
    }

}
