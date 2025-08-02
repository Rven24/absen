<?php

namespace App\Filament\Pages;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class AttendanceSummary extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static string $view = 'filament.pages.attendance-summary';
    protected static ?string $title = 'Rekap Karyawan';

    protected function getTableQuery(): Builder
    {
        $month = $this->selectedMonth ?? Carbon::now()->format('m');
        $year = $this->selectedYear ?? Carbon::now()->format('Y');

        $query = User::query()
            ->select('users.id', 'users.name')
            ->leftJoin('attendances', 'users.id', '=', 'attendances.user_id')
            ->groupBy('users.id', 'users.name');

        if ($month) {
            $query->whereRaw("DATE_FORMAT(attendances.date_check_in, '%m') = ?", [$month]);
        }
        if ($year) {
            $query->whereRaw("DATE_FORMAT(attendances.date_check_in, '%Y') = ?", [$year]);
        }

        $period = $year . '-' . $month;

        $query->selectSub(function ($query) use ($period) {
            $query->from('attendances')
                ->selectRaw('COUNT(*)')
                ->whereColumn('user_id', 'users.id')
                ->whereRaw("DATE_FORMAT(date_check_in, '%Y-%m') = ?", [$period]);
        }, 'total_hadir')
        ->selectSub(function ($query) use ($period) {
            $query->from('attendances')
                ->selectRaw('COUNT(*)')
                ->whereColumn('user_id', 'users.id')
                ->whereRaw("DATE_FORMAT(date_check_in, '%Y-%m') = ?", [$period])
                ->where('is_overtime', true);
        }, 'total_lembur')
        ->selectSub(function ($query) use ($period) {
            $query->from('attendances')
                ->selectRaw('COUNT(*)')
                ->whereColumn('user_id', 'users.id')
                ->whereRaw("DATE_FORMAT(date_check_in, '%Y-%m') = ?", [$period])
                ->where('is_late', true);
        }, 'total_terlambat');

        return $query;
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')->label('Nama Karyawan')->sortable()->searchable(),
            TextColumn::make('total_hadir')->label('Total Hadir')->sortable(),
            TextColumn::make('total_lembur')->label('Total Lembur')->sortable(),
            TextColumn::make('total_terlambat')->label('Total Terlambat')->sortable(),
        ];
    }

    protected function isTablePaginationEnabled(): bool
    {
        return true;
    }
}
