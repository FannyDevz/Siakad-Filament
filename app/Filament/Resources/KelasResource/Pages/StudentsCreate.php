<?php

namespace App\Filament\Resources\KelasResource\Pages;

use App\Filament\Resources\KelasResource;
use App\Models\ClassModel;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms\Components\Section;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class StudentsCreate extends Page implements HasForms
{
    use interactsWithForms;

    public $classId;

    protected static string $resource = KelasResource::class;

    protected static string $view = 'filament.resources.kelas-resource.pages.students-create';

    public ?array $data;

    public function __construct()
    {
        $this->data = [
            'name' => '',
            'nis' => '',
            'email' => '',
            'birthplace' => '',
            'birthdate' => '',
            'gender' => '',
            'religion' => '',
            'blood_type' => '',
            'address' => null,
            'phone' => null,
            'status' => 'active',
            'admission_date' => Carbon::now()->format('Y-m-d'),
            'graduation_date' => null,
            'photo' =>  null,
            'class_id' => static::getClassId(),
        ];
    }
    public function mount($record)
    {
        $this->classId = $record;
        return $this;
    }
    protected static function getClassId()
    {
        return request()->route('record');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Personal Information')
                ->description('Personal information of the teacher.')
                ->columns(2)
                ->schema([
                    Forms\Components\Hidden::make('class_id')
                            ->default(static::getClassId()),
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
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('create')
                ->label(__('filament-panels::resources/pages/create-record.form.actions.create.label'))
                ->submit('create'),
//            Action::make('Cancel')
//                ->label(__('filament-panels::resources/pages/create-record.form.actions.cancel.label'))
//                ->color('secondary')
//                ->url(route( 'filament.admin.resources.kelas.student', ['record' => $this->classId] )),
        ];
    }

    public function create(): void
    {
        try {
            $data = $this->data;
            if ($data['photo'] !== null) {
                foreach ( $data['photo'] as $photo) {
                    $filePath = $photo->store('public');
                    $fileName = basename($filePath);
                }
            }
            $dataUser = $data['user'];

            $birthdate = Carbon::parse($data['birthdate']);

            $year = $birthdate->year;
            $month = $birthdate->month;
            $day = $birthdate->day;

            $password = strtolower($data['birthplace'] . '-' . $day. '' .$month. '' .$year);

            $user = User::create([
                'name' => $data['name'],
                'email' => $dataUser['email'],
                'password' => Hash::make($password),
            ]);

            $user->assignRole('student');

            try {
                if ($user) {
                    Student::create([
                        'name' => $data['name'],
                        'user_id' => $user->id,
                        'class_id' => $this->classId,
                        'nis' => $data['nis'],
                        'birthplace' => $data['birthplace'],
                        'birthdate' => $data['birthdate'],
                        'gender' => $data['gender'],
                        'religion' => $data['religion'],
                        'blood_type' => $data['blood_type'] ?? null,
                        'phone' => $data['phone'] ?? null,
                        'address' => $data['address'] ?? null,
                        'status' => $data['status'],
                        'admission_date' => $data['admission_date'],
                        'graduation_date' => $data['graduation_date'] ?? null,
                        'photo' => $fileName ?? null,

                    ]);
                }
            } catch (Halt $exception) {
                return;
            }
        }  catch (Halt $exception) {
            return;
        }

        Notification::make()
            ->success()
            ->title(__('filament-panels::resources/pages/create-record.notifications.created.title'))
            ->send();


        $this->redirect(route('filament.admin.resources.kelas.student', ['record' => $this->classId]));

    }

}
