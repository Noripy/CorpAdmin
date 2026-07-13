<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

// ランディングページ
Route::get('/', function () {
    return view('welcome');
});

// TODO: 従業員一覧ページ遷移後にCRUD機能を追加する

// 従業員一覧ページ
Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');

