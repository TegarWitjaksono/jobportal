<?php

namespace App\Providers;

use App\Livewire\Forms\CustomInputErrors;
use App\Livewire\Forms\CustomValidationErrors;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Repositories\Interfaces\KategoriSoalRepositoryInterface;
use App\Repositories\EloquentKategoriSoalRepository;
use App\Repositories\Interfaces\BankSoalRepositoryInterface;
use App\Repositories\BankSoalRepository;
use App\Providers\EventServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register any application services here
        $this->app->bind(
            KategoriSoalRepositoryInterface::class,
            EloquentKategoriSoalRepository::class
        );

        $this->app->bind(
            BankSoalRepositoryInterface::class,
            BankSoalRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // inpute components blade here
        Livewire::component('custom-validation-errors', CustomValidationErrors::class);
        Livewire::component('custom-input-error', CustomInputErrors::class);

        // Customize verification email to use branded template
        VerifyEmail::toMailUsing(function ($notifiable, string $url) {
            $subject = 'Verifikasi Email Akun Anda';
            return (new MailMessage)
                ->subject($subject)
                ->view('emails.verify-email', [
                    'subject' => $subject,
                    'candidate' => $notifiable->name ?? 'Pengguna',
                    'verificationUrl' => $url,
                ]);
        });
    }
}
