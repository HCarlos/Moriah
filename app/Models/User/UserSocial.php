<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class UserSocial extends Model
{

    use Notifiable, SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'user_social';

    protected $fillable = [
        'id','user_id',
        'red_social','username_red_social','alias_red_social',
    ];

}
