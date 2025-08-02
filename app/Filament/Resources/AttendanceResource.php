<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceResource\Pages;
use App\Filament\Resources\AttendanceResource\RelationManagers;
use App\Models\Attendance;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->preload()
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nama Karyawan')
                    ->searchable(),
                TextColumn::make('date_check_in')
                    ->label('Tanggal')
                    ->formatStateUsing(fn (?string $state): string => $state ? Carbon::parse($state)->timezone('Asia/Jakarta')->format('d F Y') : '')
                    ->searchable(),
                TextColumn::make('check_in_time')
                    ->label('Absen Check-in')
                    ->formatStateUsing(fn (?string $state): string => $state ? Carbon::parse($state)->timezone('Asia/Jakarta')->format('H:i:s') : '')
                    ->sortable(),
                TextColumn::make('check_out_time')
                    ->label('Absen Check-out')
                    ->formatStateUsing(function (?string $state, Attendance $record): string {
                        if (is_null($record->check_out_time)) {
                            return 'Belum Check-out';
                        }
                        return Carbon::parse($state)->timezone('Asia/Jakarta')->format('H:i:s');
                    })
                    ->sortable(),
                IconColumn::make('is_late')
                    ->label('Terlambat')
                    ->boolean(),
                IconColumn::make('is_overtime')
                    ->label('Lembur')
                    ->boolean(),
            ])
            ->filters([
            ])
            ->actions([
                Tables\Actions\Action::make('check_out')
                    ->label('Check-out')
                    ->icon('heroicon-o-arrow-left-on-rectangle')
                    ->color('danger')
                    ->visible(function (Attendance $record): bool {
                        $user = Auth::user();
                        if ($user->role === 'admin') {
                            return false;
                        }
                        return $record->check_in_time !== null && $record->check_out_time === null;
                    })
                    ->action(function (Attendance $record) {
                        if ($record->check_in_time === null) {
                            Notification::make()
                                ->title('Anda belum melakukan Check-in.')
                                ->danger()
                                ->send();
                            return;
                        }
                        if ($record->check_out_time !== null) {
                            Notification::make()
                                ->title('Anda sudah melakukan Check-out.')
                                ->danger()
                                ->send();
                            return;
                        }
                        $checkOutTime = Carbon::now('Asia/Jakarta');
                        $record->update([
                            'check_out_time' => $checkOutTime,
                            'is_overtime' => $checkOutTime->hour >= 15,
                        ]);
                        Notification::make()
                            ->title('Check-out berhasil!')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            // 'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }

}
