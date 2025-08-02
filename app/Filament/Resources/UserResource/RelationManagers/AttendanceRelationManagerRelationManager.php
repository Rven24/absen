<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Attendance; // <-- Pastikan ini ada

class AttendancesRelationManager extends RelationManager
{
    // <-- PENTING: Pastikan ini adalah nama method relasi di model App\Models\User.php
    protected static string $relationship = 'attendances';

    // Opsional: judul yang akan muncul di tab
    protected static ?string $title = 'Riwayat Absensi Karyawan';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Form ini untuk membuat atau mengedit absensi langsung dari sini,
                // Anda bisa mengosongkannya atau menyesuaikannya.
                Forms\Components\DateTimePicker::make('check_in_time')
                    ->required(),
                Forms\Components\DateTimePicker::make('check_out_time')
                    ->nullable(),
                Forms\Components\Toggle::make('is_overtime')
                    ->label('Lembur')
                    ->inline(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('check_in_time')
            ->columns([
                Tables\Columns\TextColumn::make('check_in_time')
                    ->label('Check-in')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('check_out_time')
                    ->label('Check-out')
                    ->sortable()
                    ->formatStateUsing(function (?string $state, Attendance $record): string {
                        // Perhatikan: Pastikan Anda telah menambahkan 'use App\Models\Attendance;' di bagian atas file ini
                        if (is_null($record->check_out_time)) {
                            return 'Belum Check-out';
                        }
                        return $record->check_out_time->format('H:i:s');
                    }),
                Tables\Columns\IconColumn::make('is_overtime')
                    ->label('Lembur')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
