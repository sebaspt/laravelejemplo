<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    public function roles(){
        return $this->belongsToMany('App\Role');
    }
    // si se quiere  meter un user a un admin
    public function authorizeRoles($roles){
        if($this->hasAnyRole($roles)){
                return true;
        }
        return abort(403);

    }
    //arreglo de roles o un solo rol
    public function hasAnyRole($roles){
            if(is_array($roles)){
                foreach ($roles as $role) {
                        if($this->hasRole($role)){
                            return true;
                        }
                }
            }else{
                if($this->hasRole($roles)){
                    return true;
                }
            }
    }
    //un solo rol
    public function hasRole($role){
            if($this->roles()->where('name',$role)->first()){
                return true;
            }
            return false;
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

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
}