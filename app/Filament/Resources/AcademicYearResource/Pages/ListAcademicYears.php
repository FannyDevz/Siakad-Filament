<?php

namespace App\Filament\Resources\AcademicYearResource\Pages;

use App\Filament\Resources\AcademicYearResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListAcademicYears extends ListRecords
{
    protected static string $resource = AcademicYearResource::class;

    protected function getHeaderActions(): array
    {

        return [
            Actions\CreateAction::make(),
        ];

    }


}
