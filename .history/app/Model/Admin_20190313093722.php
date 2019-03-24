<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;
use Laravel\Passport\HasApiTokens;
use App\Model\Admin;

class Admin extends Authenticatable
{
    use Notifiable;
    use HasMultiAuthApiTokens;
   
    protected $fillable = [
        'name', 'email', 'password', 'cpf', 'telefone', 'foto'
     ];

     protected $hidden = [
        'password',
        'remember_token',
    ];
 
     public function apiarios ()
     {
        return $this->belongsTo(Apiario::class);
     }
}
