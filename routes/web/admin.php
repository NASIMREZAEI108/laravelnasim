<?php


Route::get('/' , function() {
    return view('admin.index');
});
    Route::resource('users' , 'UserController');








