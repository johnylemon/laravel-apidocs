<?php

use Illuminate\Support\Facades\Route;

Route::get(config('apidocs.uri'), function () {

    return view('apidocs::app')->with([
        'apidocs' => @file_get_contents(config('apidocs.file_path'))
    ]);

})->name('apidocs.docs');
