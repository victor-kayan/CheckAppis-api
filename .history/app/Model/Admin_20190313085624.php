<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use App\Model\Admin;

class Admin extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;
   
    protected $fillable = [
        'name', 'email', 'password', 'cpf', 'telefone', 'foto'
     ];
 
     public function apiarios ()
     {
        return $this->belongsTo(Apiario::class);
     }
}
