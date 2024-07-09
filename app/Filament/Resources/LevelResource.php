<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LevelResource\Pages;
use App\Filament\Resources\LevelResource\RelationManagers;
use App\Models\Level;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;

class LevelResource extends Resource implements HasShieldPermissions
{

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
        ];
    }
    protected static ?string $model = Level::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-on-square-stack';

    protected static ?string $navigationGroup = 'Base Configuration';

    protected static ?string $label = 'Tingkat';

    protected static ?string $navigationLabel = 'Tingkat';

//    public static function getNavigationBadge(): ?string
//    {
//        return static::getModel()::count();
//    }
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->button()->color('warning'),
//                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListLevels::route('/'),
            'create' => Pages\CreateLevel::route('/create'),
//            'edit' => Pages\EditLevel::route('/{record}/edit'),
        ];
    }
}
