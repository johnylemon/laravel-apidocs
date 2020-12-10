<?php

use Johnylemon\Apidocs\Tests\Data\TestEndpoint;

Route::get('test', fn() => [])->name('test')->apidocs(TestEndpoint::class);
Route::get('anothertest', fn() => [])->name('anothertest')->apidocs(TestEndpoint::class);

Route::get('test1', fn() => [])->name('test1');
Route::get('test2', fn() => [])->name('test2');
Route::get('test3', fn() => [])->name('test3');
Route::get('test4', fn() => [])->name('test4');
