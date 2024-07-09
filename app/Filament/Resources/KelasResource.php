<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KelasResource\Pages;
use App\Filament\Resources\KelasResource\RelationManagers;
use App\Models\ClassModel;
use App\Models\Kelas;
use App\Models\Teacher;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Illuminate\Support\Str;

class KelasResource extends Resource implements HasShieldPermissions
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
    protected static ?string $model = ClassModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationGroup = 'Data';

    protected static ?string $label = 'Kelas';

    protected static ?string $navigationLabel = 'Kelas';

    public static function getNavigationBadge(): ?string
    {   $role = auth()->user()->roles->pluck('name')->toArray();
        $isadmin = in_array('super_admin', $role);
        if ($isadmin) {
            return static::getModel()::count();
        } else {
            return null;
        }
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description'),
                Forms\Components\Select::make('status')->options([
                    'active' => 'Active',
                    'inactive' => 'Inactive',
                ])
                    ->default('active')
                    ->required(),
                Forms\Components\Select::make('academic_year_id')
                    ->relationship('academicYear', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('semester_id')
                    ->relationship('semester', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('teacher_id')
                    ->label('Wali Kelas')
                    ->relationship('teacher', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('department_id')
                    ->relationship('department', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('level_id')
                    ->relationship('level', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),


            ]);
    }

    public static function table(Table $table): Table
    {
        $role = auth()->user()->roles->pluck('name')->toArray();
        $isadmin = in_array('super_admin', $role);
        return $table
            ->modifyQueryUsing(
                static function (Builder $query) use ($isadmin) {
                    if (!$isadmin) {
                        $query->where('status', 'active');
                    }
                }
            )
            ->columns([
                Stack::make([
                    Split::make([
                        Tables\Columns\TextColumn::make('name')
                            ->searchable()
                            ->weight(FontWeight::Bold)
                            ->sortable(),

                        Tables\Columns\TextColumn::make('status')
                            ->searchable()
                            ->formatStateUsing(fn ($state): string => Str::headline($state))
                            ->badge()
                            ->color(
                                fn (ClassModel $record): string => match ($record->status) {
                                    'active' => 'success',
                                    'inactive' => 'danger',
                                    default => 'warning',
                                }
                            )
                            ->alignEnd()
                            ->sortable(),
                    ])->from('md'),
                    Tables\Columns\TextColumn::make('description')
                        ->searchable()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('department.name')
                        ->searchable()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('level.name')
                        ->searchable()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('semester.name')
                        ->searchable()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('academicYear.name')
                        ->searchable()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('teacher.name')
                        ->searchable()
                        ->sortable(),
                ]),


            ]) ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->defaultGroup('academicYear.name')
            ->groups([
                'academicYear.name' ,
                'department.name',
                'level.name',
                'semester.name',
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->label('Status'),
                Tables\Filters\SelectFilter::make('department_id')
                    ->relationship('department', 'name')
                    ->label('Department'),
                Tables\Filters\SelectFilter::make('level_id')
                    ->relationship('level', 'name')
                    ->label('Level'),
                Tables\Filters\SelectFilter::make('academic_year_id')
                    ->relationship('academicYear', 'name')
                    ->label('Academic Year'),
                Tables\Filters\SelectFilter::make('semester_id')
                    ->relationship('semester', 'name')
                    ->label('Semester'),
                Tables\Filters\SelectFilter::make('teacher_id')
                    ->relationship('teacher', 'name')
                    ->label('Wali Kelas'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->color('warning')->button(),
                Tables\Actions\Action::make('Lihat Siswa')
                    ->color('primary')
                    ->button()
                    ->url(fn (ClassModel $record):string =>self::getUrl('student' , ['record' => $record->id])),
            ])
            ->bulkActions([
//                BulkAction::make('export')->button()->action(fn (Collection $records) => ...),
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
            'index' => Pages\ListKelas::route('/'),
            'student' => Pages\StudentsData::route('/student/{record}/'),
            'student-create' => Pages\StudentsCreate::route('/student/{record}/create/'),
        ];
    }
}
