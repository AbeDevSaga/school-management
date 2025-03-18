<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Providers\Filament\StudentPanelProvider;
use App\Providers\Filament\TeacherPanelProvider;
use Filament\Facades\Filament;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Filament::registerPanelProvider(StudentPanelProvider::class);
        // Filament::registerPanelProvider(TeacherPanelProvider::class);
    }
}
