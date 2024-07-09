<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoomResource\Pages;
use App\Filament\Resources\RoomResource\RelationManagers;
use App\Models\Room;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;

class RoomResource extends Resource implements HasShieldPermissions
{
    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
        ];
    }

    protected static ?string $model = Room::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationGroup = 'Base Configuration';

    protected static ?string $label = 'Ruangan';

    protected static ?string $navigationLabel = 'Ruangan';
    protected static ?int $navigationSort = 5;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('capacity')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description'),
                Forms\Components\Select::make('status')->options([
                    'active' => 'Active',
                    'inactive' => 'Inactive',
                ])
                    ->default('active')
                    ->required(),
                Forms\Components\Select::make('type')->options([
                    'classroom' => 'Ruang Mengajar',
                    'public' => 'Ruang Publik',
                    'laboratory' => 'Laboratorium',
                    'staffroom' => 'Ruang Staff',
                    'others' => 'Lainnya',
                ])
                    ->default('active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('capacity')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ]),
                Tables\Columns\SelectColumn::make('type')
                    ->options([
                        'classroom' => 'Ruang Mengajar',
                        'public' => 'Ruang Publik',
                        'laboratory' => 'Laboratorium',
                        'staffroom' => 'Ruang Staff',
                        'others' => 'Lainnya',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->label('Status'),

                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'classroom' => 'Ruang Mengajar',
                        'public' => 'Ruang Publik',
                        'laboratory' => 'Laboratorium',
                        'staffroom' => 'Ruang Staff',
                        'others' => 'Lainnya',
                    ])
            ])
            ->actions([
                Tables\Actions\EditAction::make()->button()->color('warning'),
                Tables\Actions\DeleteAction::make()->button()->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultGroup('type')
            ->groups([
                'type',
                'status'
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRooms::route('/'),
        ];
    }
}
