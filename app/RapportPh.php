<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RapportPh extends Model
{
    //
    protected $table='rapport_phs';
    protected $primaryKey='rapport_ph_id';
    //protected $fillable=['*'];
    protected $guarded = ['rapport_ph_id']; 
    //protected $guarded = ['*'];

}
