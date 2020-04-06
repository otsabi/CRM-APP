<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Role extends Model
{
    //
    protected $table='roles';
    protected $primaryKey='role_id';

    protected $fillable = ['role_id','libelle'];

    public function users(){
        return $this->hasMany('App\User','role_id');
    }

}
