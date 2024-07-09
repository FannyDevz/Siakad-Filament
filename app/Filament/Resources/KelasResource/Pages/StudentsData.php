<?php

namespace App\Filament\Resources\KelasResource\Pages;

use App\Filament\Resources\KelasResource;
use App\Models\ClassModel;
use App\Models\Student;
use Filament\Forms\Components\Section;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms;
use Filament\Tables\Concerns\InteractsWithTable;
use Hamcrest\SelfDescribing;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions;

class StudentsData extends Page implements HasTable, HasForms
{
    use InteractsWithTable;
    use interactsWithForms;

    protected static string $resource = KelasResource::class;

    protected static string $view = 'filament.resources.kelas-resource.pages.students-data';

    public $record;

    public function mount($record)
    {
        $this->record = $record;
    }

    public function form(Form $form): Form
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
                            ->required(),
                        Forms\Components\DatePicker::make('admission_date')
                            ->required(),
                        Forms\Components\DatePicker::make('graduation_date'),
                        Forms\Components\FileUpload::make('photo')
                            ->image()
                            ->maxSize(5120),
                    ])
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make('Add Student In Class')->color('primary'),
            Actions\Action::make("Add Student In Class")->color('primary')
                ->button()
                ->url(route('filament.admin.resources.kelas.student-create', ['record' => $this->record ])),
        ];
    }

    public static function table(Table $table): Table
    {

        return $table
            ->query(Student::query())
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
            ->modifyQueryUsing(
                static function (Builder $query)  {
                    $query->where('class_id', $this->record->id);
                }
            )
            ;
    }
}
