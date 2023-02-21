<?php

//No routes in here!
use App\Http\Controllers\Auth\AuthController;



Route::get('/db', function () {
    return 'wq111s3';
});

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});
