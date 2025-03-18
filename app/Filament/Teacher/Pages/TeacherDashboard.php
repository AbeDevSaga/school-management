<?php

namespace App\Filament\Teacher\Pages;

use Filament\Pages\Page;

class TeacherDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.teacher.pages.teacher-dashboard';

    protected static ?string $navigationLabel = 'Teacher Dashboard';
    protected static ?string $title = 'Teacher Dashboard';
    protected static ?string $slug = 'teacher-dashboard';

    public function mount()
    {
        if (!\Illuminate\Support\Facades\Auth::user()->role !== 'teacher') {
            abort(403);
        }
    }
}
