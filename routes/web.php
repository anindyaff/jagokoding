<?php 
 
use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\BarangController; 
use App\Http\Controllers\RegisterController; 
use App\Http\Controllers\LoginController; 
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangmasukController; 
use App\Http\Controllers\BarangkeluarController; 
 
/* 
|-------------------------------------------------------------------------- 
| Web Routes 
|-------------------------------------------------------------------------- 
| 
| Here is where you can register web routes for your application. These 
| routes are loaded by the RouteServiceProvider and all of them will 
| be assigned to the "web" middleware group. Make something great! 
| 
*/ 
 
Route::get('/', function () { 
    return view('welcome'); 
}); 
 
Route::resource('barang', BarangController::class); 
 
Route::get('/stembayo', function () { 
    return "welcome to SIJA"; 
}); 
 
Route::get('/', function () { 
    return view('welcome'); 
}); 
 
Route::resource('kategori', KategoriController::class); 
 
Route::resource('barang', BarangController::class)->middleware('auth'); 
Route::resource('barangmasuk', BarangmasukController::class)->middleware('auth'); 
Route::resource('barangkeluar', BarangkeluarController::class)->middleware('auth'); 
 
Route::get('/login', [LoginController::class,'index'])->name('login')->middleware('guest'); 
Route::post('/login', [LoginController::class,'authenticate']); 

Route::get('/logout', [LoginController::class,'logout']); 
Route::post('/logout', [LoginController::class,'logout']); 
 
Route::post('register', [RegisterController::class,'store']); 
Route::get('/register', [RegisterController::class,'create']);