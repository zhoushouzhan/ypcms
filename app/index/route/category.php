<?php
use think\facade\Route;
Route::get("/article$", 'index/Category/index', 'GET')->append(['categoryId' => 1]);
Route::get("/article/sanwen$", 'index/Category/index', 'GET')->append(['categoryId' => 2]);
Route::get("/article/sanwen/:id$", 'index/Content/index', 'GET')->append(['categoryId' => 2]);
