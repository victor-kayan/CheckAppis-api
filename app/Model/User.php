<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'foto', 'tecnico_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at', 'created_at',
    ];

    protected $hidden = [
        'deleted_at', 'updated_at', 'password', 'email_verified_at', 'remember_token', 'created_at', 'tecnico_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function apiarios()
    {
        return $this->hasMany(Apiario::class);
    }

    // public function qtdApiarios() {

    //     $apiarios = Apiario::where('id',)
    // }

    /**
     * Metodos para permissões.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function authorizeRoles($roles)
    {
        //abort(401, $roles);
        //if (is_array($roles)) {
        //return $this->hasAnyRole($roles) ||
        //abort(401, 'This action is unauthorized.');
        // }

        return $this->hasRole($roles);
        //abort(401, 'This action is unauthorized.');
    }

    /**
     * Check multiple roles.
     *
     * @param array $roles
     */
    public function hasAnyRole($roles)
    {
        return null !== $this->roles()->whereIn('name', $roles)->first();
    }

    /**
     * Check one role.
     *
     * @param string $role
     */
    public function hasRole($role)
    {
        return null !== $this->roles()->where('name', $role)->first();
    }
}
