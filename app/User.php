<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Role;
use App\Gamme;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $table = 'users';
    protected $primaryKey='user_id';


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * Scope a query to only include non admin users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNonAdmin($query)
    {
        return $query->whereHas('role',function (Builder $query) {
            $query->whereNotIn('libelle',['ADMIN','SUPADMIN']);
        });
    }

    public function role()
    {
        return $this->belongsTo('App\Role','role_id');

    }

    public function hasRole(array $roles){
        return in_array($this->role->libelle,$roles) ? true : false;
    }

    public function isAdmin(){
        return $this->role->libelle === "ADMIN" || $this->role->libelle === "SUPADMIN" ? true : false;
    }

    public function isDistrictManager(){
        return $this->role->libelle === "DSM" ? true : false;
    }

    public function gammes()
    {
        return $this->belongsToMany('App\Gamme','user_gammes','user_id','gamme_id');
    }

    public function ville()
    {
        return $this->belongsTo('App\Ville','ville_id');
    }

    public function visiteMedicales(){
        return $this->hasMany('App\VisiteMedical','user_id');
    }

    public function visitePharmacies(){
        return $this->hasMany('App\VisitePharmacie','user_id');
    } 

    public function manager()
    {
        return $this->belongsTo('App\User', 'manager_id','user_id');
    }

    public function collaborateurs(){
        return $this->hasMany('App\User', 'manager_id','user_id')->nonAdmin();
    }

    public function bcs(){
        return $this->hasMany('App\Bc','manager_id','user_id');
    }
}
