<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class SessionModel extends Model{

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'sessions';
    protected $fillable = ['id','user_id','ip_address','user_agent','payload','last_activity',];

}
