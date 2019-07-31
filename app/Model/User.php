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

    protected $fillable = [
        'name', 'email', 'password', 'foto', 'tecnico_id', 'endereco_id', 'telefone',
    ];

    protected $dates = [
        'deleted_at', 'created_at',
    ];

    protected $hidden = [
        'deleted_at', 'updated_at', 'password', 'email_verified_at', 'remember_token', 'created_at', 'tecnico_id',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function endereco()
    {
        return $this->belongsTo(Endereco::class);
    }

    public function apiarios()
    {
        return $this->hasMany(Apiario::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function authorizeRoles($roles)
    {
        if (is_array($roles)) {
            return $this->hasAnyRole($roles) ||
             abort(401, 'Não autorizado.');
        }

        return $this->hasRole($roles) ||
         abort(401, 'Não autorizado.');
    }

    public function hasAnyRole($roles)
    {
        return null !== $this->roles()->whereIn('name', $roles)->first();
    }

    public function hasRole($role)
    {
        return null !== $this->roles()->where('name', $role)->first();
    }
}
