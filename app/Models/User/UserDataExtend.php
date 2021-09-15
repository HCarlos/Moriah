<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class UserDataExtend extends Model
{
    use Notifiable, SoftDeletes;

    protected $guard_name = 'web';
    protected $table = 'user_extend';

    protected $fillable = [
        'id','user_id',
        'lugar_nacimiento','ocupacion','profesion','lugar_trabajo',
    ];

}
