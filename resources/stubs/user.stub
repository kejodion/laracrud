<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Kjjdion\Laracrud\Traits\ColumnFillable;

class User extends Authenticatable
{
    use Notifiable, ColumnFillable;

    protected $hidden = ['password', 'remember_token'];
}