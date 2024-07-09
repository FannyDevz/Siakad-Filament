<?php

namespace App\Filament\Resources\TeacherResource\Pages;

use App\Filament\Resources\TeacherResource;
use Filament\Actions;
use Filament\Forms\Components\Section;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;

use Filament\Forms;
class EditTeacher extends EditRecord
{
    protected static string $resource = TeacherResource::class;

//    protected function getHeaderActions(): array
//    {
//        return [
//            Actions\DeleteAction::make(),
//        ];
//    }

}
