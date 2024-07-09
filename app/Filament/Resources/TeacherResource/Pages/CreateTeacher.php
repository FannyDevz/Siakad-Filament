<?php

namespace App\Filament\Resources\TeacherResource\Pages;

use App\Filament\Resources\TeacherResource;
use App\Models\ModelHasRole;
use App\Models\User;
use Filament\Actions;
use Filament\Forms\Components\Section;
use Filament\Resources\Pages\CreateRecord;

class CreateTeacher extends CreateRecord
{
    protected static string $resource = TeacherResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $dataUser = $data['user'];

        $user = User::create([
            'name' => $data['name'],
            'email' => $dataUser['email'],
            'password' => $dataUser['password'],
        ]);

        $user->assignRole('teacher');

        $data['user_id'] = $user->id;

        return $data;
    }
}
