<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MessageResource\Pages;
use App\Models\Message;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Builder;

class MessageResource extends Resource
{
    protected static ?string $model = Message::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // Form definition for creating/editing messages
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('sender_id')
                    ->required()
                    ->numeric()
                    ->label('Sender ID'),
                
                Forms\Components\TextInput::make('receiver_id')
                    ->required()
                    ->numeric()
                    ->label('Receiver ID'),
                
                Forms\Components\Textarea::make('content')
                    ->required()
                    ->columnSpanFull()
                    ->label('Message Content'),
            ]);
    }

    // Table definition for displaying messages
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sender_id')
                    ->numeric()
                    ->sortable()
                    ->label('Sender ID'),

                TextColumn::make('receiver_id')
                    ->numeric()
                    ->sortable()
                    ->label('Receiver ID'),

                TextColumn::make('content')
                    ->limit(50)  // Limit content to the first 50 characters
                    ->label('Message Preview'),

                BooleanColumn::make('is_deleted')  // Assuming a soft delete column
                    ->label('Deleted')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Created At'),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Updated At'),
            ])
            ->filters([
                // Other filters
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
                    // Apply filter logic: Filter messages within the date range
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
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    // Define relations if any (e.g., users related to messages)
    public static function getRelations(): array
    {
        return [
            // Add relations if needed
        ];
    }

    // Define pages for CRUD operations
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMessages::route('/'),
            'create' => Pages\CreateMessage::route('/create'),
            'edit' => Pages\EditMessage::route('/{record}/edit'),
        ];
    }
}
