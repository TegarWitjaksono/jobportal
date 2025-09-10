<?php
// TODO: Add role-based redirection middleware, Add role for each role type in officer
use Illuminate\Support\Facades\Route;

Route::get('/', App\Livewire\Kandidat\Dashboard::class)->name('dashboard');
Route::get('/jobs', [App\Http\Controllers\JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/browse', [App\Http\Controllers\JobController::class, 'browse'])->name('jobs.browse');
Route::get('/kategori', App\Livewire\KategoriLowongan\ListKategori::class)->name('kategori.list');
Route::get('/list-lowongan', App\Livewire\Lowongan\ListLowongan::class)->name('lowongan.list');
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:officer', // pastikan user adalah officer
])->group(function () {
    Route::get('/officers', App\Livewire\Officer\Index::class)->name('officers.index');

    // Kategori Lowongan - manager, recruiter, coordinator
    Route::get('/kategori-lowongan', App\Livewire\KategoriLowongan\Index::class)
        ->middleware('role:officer,manager,recruiter,coordinator')
        ->name('kategori-lowongan.Index');

    // Lowongan - manager, recruiter, coordinator
    Route::get('/Lowongan/Index', App\Livewire\Lowongan\Index::class)
        ->middleware('role:officer,manager,recruiter,coordinator')
        ->name('Lowongan.Index');
    Route::get('/Lowongan/Create', App\Livewire\Lowongan\Create::class)
        ->middleware('role:officer,manager,recruiter,coordinator')
        ->name('Lowongan.Create');
    Route::get('/Lowongan/{id}/edit', App\Livewire\Lowongan\Edit::class)
        ->middleware('role:officer,manager,recruiter,coordinator')
        ->name('Lowongan.Edit');

    
    // Bank Soal & Kategori Soal - manager, coordinator
    Route::get('/bank-soal', App\Livewire\BankSoal\Index::class)
        ->middleware('role:officer,manager,coordinator')
        ->name('bank-soal.index');
    Route::get('/kategori-soal', App\Livewire\KategoriSoal\Index::class)
        ->middleware('role:officer,manager,coordinator')
        ->name('kategori-soal.index');

    // Test Results - manager, recruiter, coordinator
    Route::get('/test-results', App\Livewire\Officer\TestResults\Index::class)
        ->middleware('role:officer,manager,recruiter,coordinator')
        ->name('test-results.index');

    // Manajemen Kandidat - asumsi khusus manager
    Route::get('kandidat', App\Livewire\Officer\Kandidat\Index::class)
        ->middleware('role:officer,manager,coordinator')
        ->name('kandidat.index');

    // Lamaran Lowongan - manager, recruiter, coordinator (aksi akan dinonaktifkan di Blade untuk recruiter)
    Route::get('/lamaran-lowongan', App\Livewire\Officer\LamaranLowongan\Index::class)
        ->middleware('role:officer,manager,recruiter,coordinator')
        ->name('lamaran-lowongan.index');

    // Jadwal Interview - asumsi khusus manager
    Route::get('/jadwal-interview', App\Livewire\Officer\InterviewSchedule\Index::class)
        ->middleware('role:officer,manager,recruiter,coordinator')
        ->name('jadwal-interview.index');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:kandidat',
])->group(function () {
    Route::get('/kandidat/complete-apply', App\Livewire\Kandidat\CompleteApply::class)->name('kandidat.settings');
    Route::get('/lowongan-dilamar', App\Livewire\Kandidat\LowonganDilamar\Index::class)->name('kandidat.lowongan-dilamar');
    Route::get('/kandidat/lowongan-dilamar', App\Livewire\Kandidat\LowonganDilamar\Index::class)
        ->name('kandidat.lowongan-dilamar');
    Route::get('/cbt', App\Livewire\Cbt\Index::class)->name('cbt.index');
    Route::get('/cbt/test', App\Livewire\Cbt\Test::class)->name('cbt.test');
    Route::get('/cbt/dashboard', App\Livewire\Cbt\Dashboard::class)->name('cbt.dashboard');
    Route::get('/profile', App\Livewire\Profile\ShowProfile::class)->name('profile.show');
    Route::get('/profile/edit', App\Livewire\Profile\UpdateKandidatProfileForm::class)->name('profile.edit');
});

