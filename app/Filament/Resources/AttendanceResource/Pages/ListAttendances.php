<?php

namespace App\Filament\Resources\AttendanceResource\Pages;

use App\Filament\Resources\AttendanceResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListAttendances extends ListRecords
{
    protected static string $resource = AttendanceResource::class;

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return parent::getTableQuery();
        }
        return parent::getTableQuery()->where('user_id', $user->id);
    }
    
    protected function getHeaderActions(): array
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return [];
        }
        return [
            Actions\Action::make('check_in')
                ->label('Masuk')
                ->icon('heroicon-o-arrow-right-on-rectangle')
                ->action(function () use ($user) {
                    $todayAttendance = \App\Models\Attendance::where('user_id', $user->id)
                        ->whereDate('check_in_time', now()->toDateString())
                        ->first();

                    if ($todayAttendance) {
                        Notification::make()
                            ->title('Anda sudah melakukan Check-in hari ini.')
                            ->danger()
                            ->send();
                        return;
                    }

                    \App\Models\Attendance::create([
                        'user_id' => $user->id,
                        'date_check_in' => now(),
                        'check_in_time' => now(),
                    ]);

                    Notification::make()
                        ->title('Check-in berhasil!')
                        ->success()
                        ->send();

                    $this->redirect(request()->header('Referer'));
                })
                ->requiresConfirmation()
                ->color('primary')
                ->disabled(function () use ($user) {
                    return \App\Models\Attendance::where('user_id', $user->id)
                        ->whereDate('check_in_time', now()->toDateString())
                        ->exists();
                }),
        ];
    }
}
