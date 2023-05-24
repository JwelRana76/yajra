<?php

use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DatatablesController;
use App\Http\Controllers\UsersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('employee', EmployeeController::class);

// Route::get('employee',[EmployeeController::class, 'index'])->name('employee');
// Route::get('employeeGet',[EmployeeController::class, 'view'])->name('employee.get');
// Route::get('employeeEdit/{id}',[EmployeeController::class, 'edit'])->name('employee.eidt');
// Route::get('employeeDelete/{id}',[EmployeeController::class, 'show'])->name('employee.delete');

Route::get('datatables',[DatatablesController::class, 'index'])->name('datatables');
Route::get('anyData',[DatatablesController::class, 'anyData'])->name('datatables.data');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/users',[UsersController::class, 'index'])->name('users.index');
