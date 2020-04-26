<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

//    protected $table = 'users';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    const ROLE_SUPERADMIN = 'ROLE_SUPERADMIN';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_USER = 'ROLE_USER';

    private const ROLES_HIERARCHY = [
        self::ROLE_SUPERADMIN => [self::ROLE_ADMIN, self::ROLE_USER],
        self::ROLE_ADMIN => [self::ROLE_USER],
        self::ROLE_USER => []
    ];

//    private static $ROLES = [
//        'ROLE_SUPERADMIN',
//        'ROLE_ADMIN',
//        'ROLE_USER'
//    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function articles()
    {
        return $this->hasMany('App\Article', 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'user_id', 'id');

    }

    public function userable()
    {
        return $this->morphTo();
    }

    public function isGranted($role)
    {
        if($role === $this->role || in_array($role, self::ROLES_HIERARCHY[$this->role])) {
            return true;
        }

//        return array_search($role, self::$ROLES) >= array_search($this->role, self::$ROLES);
    }

//    public function isGranted($role)
//    {
//        if ($role === $this->role) {
//            return true;
//        }
//
//        return self::isRoleInHierarchy($role, self::ROLES_HIERARCHY[$this->role]);
//
////        return array_search($role, self::$ROLES) >= array_search($this->role, self::$ROLES);
//    }
//
//    private static function isRoleInHierarchy($role, $role_hierarchy)
//    {
//        if (in_array($role, $role_hierarchy)) {
//            return true;
//        }
//
//        foreach ($role_hierarchy as $role_included) {
//            if (self::isRoleInHierarchy($role, self::ROLES_HIERARCHY[$role_included])) {
//                return true;
//            }
//        }
//
//        return false;
//    }
}

