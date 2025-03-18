<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GradeResource\Pages;
use App\Filament\Resources\GradeResource\RelationManagers;
use App\Models\Grade;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class GradeResource extends Resource
{
    protected static ?string $model = Grade::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('subject_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('student_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('marks')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('subject_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('student_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('marks')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Date Range Filter for created_at
                Forms\Components\DatePicker::make('start_date')
                    ->label('Start Date')
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('start_date', $state);
                    }),

                Forms\Components\DatePicker::make('end_date')
                    ->label('End Date')
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('end_date', $state);
                    }),
            ])
            ->query(function (Builder $query) {
                // Get the start and end dates
                $startDate = request()->input('start_date');
                $endDate = request()->input('end_date');

                if ($startDate && $endDate) {
                    // Apply filter logic: Filter grades within the date range
                    return $query->whereBetween('created_at', [$startDate, $endDate]);
                } elseif ($startDate) {
                    // Apply filter if only start date is selected
                    return $query->whereDate('created_at', '>=', $startDate);
                } elseif ($endDate) {
                    // Apply filter if only end date is selected
                    return $query->whereDate('created_at', '<=', $endDate);
                }

                return $query;
            })
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Define any relations if necessary
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGrades::route('/'),
            'create' => Pages\CreateGrade::route('/create'),
            'edit' => Pages\EditGrade::route('/{record}/edit'),
        ];
    }
}
