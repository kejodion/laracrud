<?php

Route::group(['middleware' => 'web'], function () {

    // auth
    Route::get('login', config('laracrud.controllers.auth.login') . '@loginPage')->name('login');
    Route::post('login', config('laracrud.controllers.auth.login') . '@login');
    Route::post('logout', config('laracrud.controllers.auth.login') . '@logout')->name('logout');
    Route::get('profile', config('laracrud.controllers.auth.profile') . '@updateModal')->name('profile');
    Route::patch('profile', config('laracrud.controllers.auth.profile') . '@update');
    Route::get('password', config('laracrud.controllers.auth.profile') . '@passwordModal')->name('password');
    Route::patch('password', config('laracrud.controllers.auth.profile') . '@password');

    // admin home
    Route::get('admin', config('laracrud.controllers.admin.home') . '@index')->name('admin');

    // admin users
    Route::get('admin/users', config('laracrud.controllers.admin.user') . '@index')->name('admin.users');
    Route::get('admin/users/datatables', config('laracrud.controllers.admin.user') . '@datatables')->name('admin.users.datatables');
    Route::get('admin/users/create', config('laracrud.controllers.admin.user') . '@createModal')->name('admin.users.create');
    Route::post('admin/users/create', config('laracrud.controllers.admin.user') . '@create');
    Route::get('admin/users/update/{user}', config('laracrud.controllers.admin.user') . '@updateModal')->name('admin.users.update');
    Route::patch('admin/users/update/{user}', config('laracrud.controllers.admin.user') . '@update');
    Route::get('admin/users/password/{user}', config('laracrud.controllers.admin.user') . '@passwordModal')->name('admin.users.password');
    Route::patch('admin/users/password/{user}', config('laracrud.controllers.admin.user') . '@password');
    Route::delete('admin/users/delete/{user}', config('laracrud.controllers.admin.user') . '@delete')->name('admin.users.delete');

});