<?php

use Johnylemon\Apidocs\Tests\Data\TestEndpoint;

Route::get('test', function() {})->name('test')->apidocs(TestEndpoint::class);
Route::get('anothertest', function() { return []; })->name('anothertest')->apidocs(TestEndpoint::class);

Route::get('test1', function() { return []; })->name('test1');
Route::get('test2', function() { return []; })->name('test2');
Route::get('test3', function() { return []; })->name('test3');
Route::get('test4', function() { return []; })->name('test4');
