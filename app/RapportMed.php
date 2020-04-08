<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RapportMed extends Model
{
    //
    protected $table='rapport_meds';
    protected $primaryKey='rapport_med_id';
    //protected $fillable=['*'];
    protected $guarded = ['rapport_med_id']; 
    //protected $guarded = ['*'];

}
