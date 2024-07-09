<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\ClassModel;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Illuminate\Support\Facades\Hash;

class StudentResource extends Resource implements HasShieldPermissions
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

    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Data';

    protected static ?string $label = 'Siswa';

    protected static ?string $navigationLabel = 'Siswa';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Personal Information')
                    ->description('Personal information of the teacher.')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('user.email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->hidden(fn (string $context) => $context === 'edit')
                            ->disabled(fn (string $context) => $context === 'edit'),
                        Forms\Components\TextInput::make('nis')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('class_id')
                            ->relationship('class', 'name', fn (Builder $query) => $query->where('status' , 'active'))
                            ->getOptionLabelFromRecordUsing(fn (?ClassModel $record) => "{$record->level->name} {$record->name} {$record->academicYear->name} ")
                             ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('birthplace')
                            ->maxLength(255)
                            ->required(),
                        Forms\Components\DatePicker::make('birthdate')
                            ->required(),
                        Forms\Components\Select::make('gender')
                            ->options([
                                'male' => 'Male',
                                'female' => 'Female',
                            ])
                            ->required(),
                        Forms\Components\Select::make('religion')
                            ->options([
                                'islam' => 'Islam',
                                'kristen' => 'Kristen',
                                'katholik' => 'Katholik',
                                'hindu' => 'Hindu',
                                'budha' => 'Budha',
                                'konghucu' => 'Konghucu',
                                'other' => 'Lainnya',
                            ])
                            ->required(),
                        Forms\Components\Select::make('blood_type')
                            ->options([
                                'a' => 'A',
                                'b' => 'B',
                                'ab' => 'AB',
                                'o' => 'O',
                                'other' => 'Lainnya',
                            ]),
                        Forms\Components\TextInput::make('phone')
                            ->tel('+62')
                            ->maxLength(13),
                        Forms\Components\Textarea::make('address')
                            ->maxLength(65535),
                        Forms\Components\Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                            ])
                            ->default('active')
                            ->required(),
                        Forms\Components\DatePicker::make('admission_date')
                            ->default(now())
                            ->required(),
                        Forms\Components\DatePicker::make('graduation_date'),
                        Forms\Components\FileUpload::make('photo')
                            ->image()
                            ->maxSize(5120),


                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nis')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('admission_date')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('graduation_date')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ]),
                Tables\Filters\SelectFilter::make('religion')
                    ->options([
                        'islam' => 'Islam',
                        'kristen' => 'Kristen',
                        'katholik' => 'Katholik',
                        'hindu' => 'Hindu',
                        'budha' => 'Budha',
                        'konghucu' => 'Konghucu',
                        'other' => 'Lainnya',
                    ]),
                Tables\Filters\SelectFilter::make('blood_type')
                    ->options([
                        'a' => 'A',
                        'b' => 'B',
                        'ab' => 'AB',
                        'o' => 'O',
                        'other' => 'Lainnya',
                    ]),
                Tables\Filters\SelectFilter::make('gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                        'other' => 'Lainnya',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->button()->color('warning'),
                Tables\Actions\ViewAction::make()->button()->color('info'),
            ])
            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
