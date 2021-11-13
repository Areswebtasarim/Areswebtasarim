<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\AdminYonetim;
use RealRashid\SweetAlert\Facades\Alert;



Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/yonetim',[AdminYonetim::class,'home'])->name('home');
Route::get('/yonetim/moduller',[App\Http\Controllers\ModulController::class,"index"])->name('moduller');
Route::post('/yonetim/modul-ekle',[ModulController::class,"modulekle"])->name('modul-ekle');
Route::get('/yonetim/liste/{modul}',[AdminYonetim::class,"liste"])->name('liste');
Route::get('/yonetim/ekle/{modul}',[AdminYonetim::class,"ekle"])->name('ekle');
Route::post('/yonetim/ekle-post/{modul}',[AdminYonetim::class,"eklePost"])->name('eklepost');
Route::get('/yonetim/duzenle/{modul}/{id}',[AdminYonetim::class,"duzenle"])->name('duzenle');
Route::post('/yonetim/duzenle-post/{modul}/{id}',[AdminYonetim::class,"duzenlePost"])->name('duzenlepost');
Route::get('/yonetim/sil/{modul}/{id}',[AdminYonetim::class,"sil"])->name('sil');
Route::get('/yonetim/durum/{modul}/{id}',[AdminYonetim::class,"durum"])->name('durum');
Route::get('/yonetim/ayarlar',[AdminYonetim::class,"ayarlar"])->name('ayarlar');
Route::post('/yonetim/ayarpost',[AdminYonetim::class,"ayarpost"])->name('ayarpost');
Route::get('/yonetim/iletisim',[AdminYonetim::class,"iletisim"])->name('iletisim');
Route::post('/yonetim/iletisimpost',[AdminYonetim::class,"iletisimpost"])->name('iletisimpost');
