<?php

namespace App\Filament\Pages;

use App\Models\DailyIncome;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class DailyIncomesPage extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationLabel = 'Pendapatan Harian';
    protected static ?int $navigationSort = 3;

    protected static string $view = 'filament.pages.daily-incomes-page';
    protected static ?string $title = 'Pendapatan Harian';

    protected function getTableQuery(): Builder
    {
        return DailyIncome::query();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('date')
                ->label('Tanggal')
                ->date('d F Y'),
            TextColumn::make('user.name')
                ->label('Karyawan')
                ->formatStateUsing(fn (string $state, $record) => $record->user->name),
            TextColumn::make('amount')
                ->label('Jumlah (Rupiah)')
                ->formatStateUsing(fn (int $state) => 'Rp. ' . number_format($state, 0, ',', '.'))
                ->alignEnd(),
            TextColumn::make('transfer_income')
                ->label('Jumlah Transfer')
                ->formatStateUsing(fn (int $state) => 'Rp. ' . number_format($state, 0, ',', '.'))
                ->alignEnd(),
        ];
    }

    /**
     * Metode ini mendefinisikan aksi-aksi yang muncul di setiap baris tabel.
     * Di sinilah kita akan menambahkan tombol "Edit" dan "Delete".
     */
    protected function getTableActions(): array
    {
        return [
            // Menambahkan tombol untuk mengedit data DailyIncome
            EditAction::make()
                ->form([ // Definisikan form untuk mengedit data
                    DatePicker::make('date')
                        ->label('Tanggal')
                        ->required(),
                    Select::make('user_id')
                        ->label('Karyawan')
                        ->relationship('user', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    TextInput::make('amount')
                        ->label('Jumlah (Rupiah Tunai)')
                        ->numeric()
                        // ->mask('999,999,999,999,999') // Masking dihapus
                        // ->stripCharacters(',') // stripCharacters dihapus
                        ->prefix('Rp.')
                        ->required(),
                    TextInput::make('transfer_income')
                        ->label('Jumlah (Rupiah Transfer)')
                        ->numeric()
                        // ->mask('999,999,999,999,999') // Masking dihapus
                        // ->stripCharacters(',') // stripCharacters dihapus
                        ->prefix('Rp.')
                        ->default(0),
                ]),
            // Menambahkan tombol untuk menghapus data DailyIncome
            DeleteAction::make(),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            //
        ];
    }

    /**
     * Metode ini mendefinisikan aksi-aksi yang muncul di bagian header tabel.
     * Di sinilah kita akan menambahkan tombol "Buat Pendapatan Baru".
     */
    protected function getTableHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->model(DailyIncome::class)
                ->label('Buat Pendapatan Baru')
                ->form([
                    DatePicker::make('date')
                        ->label('Tanggal')
                        ->required()
                        ->default(now()),
                    Select::make('user_id')
                        ->label('Karyawan')
                        ->relationship('user', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    TextInput::make('amount')
                        ->label('Jumlah (Rupiah Tunai)')
                        ->numeric()
                        // ->mask('999,999,999,999,999') // Masking dihapus
                        // ->stripCharacters(',') // stripCharacters dihapus
                        ->prefix('Rp.')
                        ->required(),
                    TextInput::make('transfer_income')
                        ->label('Jumlah (Rupiah Transfer)')
                        ->numeric()
                        // ->mask('999,999,999,999,999') // Masking dihapus
                        // ->stripCharacters(',') // stripCharacters dihapus
                        ->prefix('Rp.')
                        ->default(0),
                ])
                ->createAnother(false),
        ];
    }

    protected function getTableBulkActions(): array
    {
        return [
            //
        ];
    }
}
