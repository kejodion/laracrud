<?php

return [

    // available user roles
    'roles' => ['Admin'],

    // controllers used by package
    'controllers' => [
        'admin' => [
            'home' => 'Kjjdion\Laracrud\Http\Controllers\Admin\HomeController',
            'user' => 'Kjjdion\Laracrud\Http\Controllers\Admin\UserController',
        ],
        'auth' => [
            'login' => 'Kjjdion\Laracrud\Http\Controllers\Auth\LoginController',
            'profile' => 'Kjjdion\Laracrud\Http\Controllers\Auth\ProfileController',
        ],
    ],

];