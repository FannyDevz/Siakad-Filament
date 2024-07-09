<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use App\Models\User;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $dataUser = $data['user'];

//        //get data date, month, year from $data['birthdate']
        $birthdate = Carbon::parse($data['birthdate']);

        $year = $birthdate->year;
        $month = $birthdate->month;
        $day = $birthdate->day;

//        dd($day,$month,$year);

        $password = strtolower($data['birthplace'] . '-' . $day. '' .$month. '' .$year);
        $user = User::create([
            'name' => $data['name'],
            'email' => $dataUser['email'],
            'password' => Hash::make($password),
        ]);

        $user->assignRole('student');

        $data['user_id'] = $user->id;

        return $data;
    }
}
