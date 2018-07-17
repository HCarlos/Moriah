<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class FunctionsTest extends TestCase
{
    protected $user;
    protected $password = 'secret';

    public function get_user()
    {
        if ($this->user) return;
        return $this->user = User::find(1);
    }

}
