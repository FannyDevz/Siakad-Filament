<?php

namespace App\Filament\Widgets;

use App\Models\Room;
use App\Models\Student;
use App\Models\Teacher;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $total_teacher = Teacher::count();
        $total_siswa = Student::count();
        $total_room = Room::count();


        return [
            Stat::make('Total Teacher', $total_teacher)
                ->description(' Total Teacher')
                ->icon('heroicon-o-users'),
            Stat::make('Total Siswa', $total_siswa)
                ->description('Total Siswa')
                ->icon('heroicon-o-user-group'),
            Stat::make('Total Ruangan', $total_room)
                ->description('Total Ruangan')
                ->icon('heroicon-o-building-office'),
        ];
    }
}
