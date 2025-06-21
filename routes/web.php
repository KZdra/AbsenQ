<?php

use App\Exports\TemplateSheetExport;
use App\Exports\TemplateSiswaExport;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AppConfigController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/scan',[AbsensiController::class,'absen'])->name('absen.scan');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');
    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    // Master Data


    Route::get('siswa', [\App\Http\Controllers\SiswaController::class, 'index'])->name('siswa.index');
    Route::get('siswa/template', function () {
        return Excel::download(new TemplateSheetExport, 'template_siswa.xlsx');
    })->name('siswa.template');
    Route::get('/siswa/qr/massal', [\App\Http\Controllers\SiswaController::class, 'cetakQrMassal'])->name('siswa.qr.massal');
    Route::post('siswa', [\App\Http\Controllers\SiswaController::class, 'store'])->name('siswa.store');
    Route::post('siswa/import', [\App\Http\Controllers\SiswaController::class, 'import'])->name('siswa.import');
    Route::put('siswa/{id}', [\App\Http\Controllers\SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('siswa/{id}', [\App\Http\Controllers\SiswaController::class, 'destroy'])->name('siswa.destroy');

    Route::get('kelas', [\App\Http\Controllers\KelasController::class, 'index'])->name('kelas.index');
    Route::post('kelas', [\App\Http\Controllers\KelasController::class, 'store'])->name('kelas.store');
    Route::put('kelas/{id}', [\App\Http\Controllers\KelasController::class, 'update'])->name('kelas.update');
    Route::delete('kelas/{id}', [\App\Http\Controllers\KelasController::class, 'destroy'])->name('kelas.destroy');

    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::post('users', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
    Route::put('users/{id}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::delete('users/{id}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');


    Route::get('settings', [AppConfigController::class, 'index'])->name('appconfig.index');
    Route::post('settings', [AppConfigController::class, 'store'])->name('appconfig.store');
});
