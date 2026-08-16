<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeknisiController;

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {

    if (Auth::check()) {

        switch (Auth::user()->role) {

            case 'admin':
                return redirect()->route('admin.dashboard');

            case 'teknisi':
                return redirect()->route('teknisi.dashboard');

            default:
                return redirect()->route('login');
        }

    }

    return redirect()->route('login');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/teknisi', [AdminController::class, 'teknisi'])->name('teknisi');
    Route::post('/teknisi/store', [AdminController::class, 'storeTeknisi'])->name('teknisi.store');
    Route::get('/teknisi/{id}/edit', [AdminController::class, 'editTeknisi'])->name('teknisi.edit');
    Route::put('/teknisi/{id}', [AdminController::class, 'updateTeknisi'])->name('teknisi.update');
    Route::delete('/teknisi/{id}', [AdminController::class, 'destroyTeknisi'])->name('teknisi.destroy');
    Route::get('/teknisi/{id}/lokasi', [AdminController::class, 'lokasiTeknisi'])->name('teknisi.lokasi');
    Route::put('/teknisi/{id}/reset-password', [AdminController::class, 'resetPassword'])->name('teknisi.resetPassword');
    

    Route::get('/divisi', [AdminController::class, 'divisi'])->name('divisi');
    Route::get('/divisi/{id}', [AdminController::class, 'detailDivisi'])->name('divisi.detail');
    Route::get('/divisi/assurance', [AdminController::class, 'assurance'])->name('divisi.assurance');
    Route::get('/divisi/provisioning', [AdminController::class, 'provisioning'])->name('divisi.provisioning');
    
    Route::get('/target', [AdminController::class, 'target'])->name('target');
    Route::get('/target/assurance', [AdminController::class, 'targetAssurance'])->name('target.assurance');
    Route::get('/target/provisioning', [AdminController::class, 'targetProvisioning'])->name('target.provisioning');
    Route::get('/divisi/{id}', [AdminController::class, 'detailDivisi'])->name('divisi.detail');
    Route::get('/target/{id}/detail', [AdminController::class, 'detailTarget'])->name('target.detail');
    

    // Route::get('/pekerjaan', [AdminController::class, 'pekerjaan'])->name('pekerjaan');

    Route::get('/monitoring/assurance', [AdminController::class, 'monitoringAssurance'])->name('monitoring.assurance');
    Route::get('/monitoring/provisioning', [AdminController::class, 'monitoringProvisioning'])->name('monitoring.provisioning');
    Route::get('/monitoring/teknisi/{id}', [AdminController::class, 'detailMonitoring'])->name('monitoring.detail');

    Route::get('/absensi/assurance', [AdminController::class, 'absensiAssurance'])->name('absensi.assurance');
    Route::get('/absensi/provisioning', [AdminController::class, 'absensiProvisioning'])->name('absensi.provisioning');
    Route::get('/absensi/assurance/pdf', [AdminController::class, 'exportAbsensiPdfAssurance'])->name('absensi.assurance.pdf');
    Route::get('/absensi/assurance/excel', [AdminController::class, 'exportAbsensiExcelAssurance'])->name('absensi.assurance.excel');
    Route::get('/absensi/provisioning/pdf', [AdminController::class, 'exportAbsensiPdfProvisioning'])->name('absensi.provisioning.pdf');
    Route::get('/absensi/provisioning/excel', [AdminController::class, 'exportAbsensiExcelProvisioning'])->name('absensi.provisioning.excel');

    Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan');
    Route::get('/laporan/assurance', [AdminController::class, 'laporanAssurance'])->name('laporan.assurance');
    Route::get('/laporan/provisioning', [AdminController::class, 'laporanProvisioning'])->name('laporan.provisioning');
    Route::get('/laporan/{id}/detail', [AdminController::class, 'detailLaporan'])->name('laporan.detail');
    Route::get('/laporan/export/pdf', [AdminController::class, 'exportLaporanPdf'])->name('laporan.pdf');
    Route::get('/laporan/export/excel', [AdminController::class, 'exportLaporanExcel'])->name('laporan.excel');
    Route::get('/profil', [AdminController::class, 'profil'])->name('profil');

});

Route::prefix('teknisi')->name('teknisi.')->middleware(['auth', 'teknisi'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [TeknisiController::class, 'dashboard'])->name('dashboard');

    Route::get('/absensi', [TeknisiController::class, 'absensi'])->name('absensi');
    
    Route::get('/pekerjaan', [TeknisiController::class, 'pekerjaan'])->name('pekerjaan');
    Route::post('/pekerjaan', [TeknisiController::class, 'storePekerjaan'])->name('pekerjaan.store');

    Route::get('/target', [TeknisiController::class, 'target'])->name('target');

    Route::post('/checkin', [TeknisiController::class, 'checkIn'])->name('checkin');
    Route::post('/update-lokasi', [TeknisiController::class, 'updateLokasi'])->name('updateLokasi');

    Route::get('/profil', [TeknisiController::class, 'profil'])->name('profil');
    Route::get('/profil/edit', [TeknisiController::class, 'editProfil'])->name('profil.edit');
    Route::get('/password', [TeknisiController::class, 'password'])->name('password');
    Route::put('/password/update', [TeknisiController::class, 'updatePassword'])->name('password.update');
    Route::put('/profil/update', [TeknisiController::class, 'updateProfil'])->name('profil.update');

    Route::get('/riwayat-pekerjaan', [TeknisiController::class, 'riwayat'])->name('riwayat');
    Route::get('/riwayat-pekerjaan/{id}', [TeknisiController::class, 'detailPekerjaan'])->name('detailPekerjaan');
    Route::post('/checkout', [TeknisiController::class, 'checkOut'])->name('checkout');
    
});


require __DIR__.'/auth.php';
