<?php

namespace App\Filament\Pages;

use App\Models\Attendance;
use App\Models\DailyIncome;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\WithPagination;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class Report extends Page implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static string $view = 'filament.pages.report';
    protected static ?string $navigationGroup = 'Laporan';
    protected static ?string $title = 'Laporan Bulanan';

    public ?int $selected_month = null;
    public ?int $selected_year = null;

    public function mount(): void
    {
        $this->selected_month = now()->month;
        $this->selected_year = now()->year;
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('selected_month')
                    ->label('Pilih Bulan')
                    ->options(function () {
                        $months = [];
                        for ($i = 1; $i <= 12; $i++) {
                            $months[$i] = Carbon::create(null, $i)->locale('id')->monthName;
                        }
                        return $months;
                    })
                    ->default(now()->month)
                    ->live(),

                Select::make('selected_year')
                    ->label('Pilih Tahun')
                    ->options(function () {
                        $years = [];
                        for ($i = Carbon::now()->year; $i >= 2020; $i--) {
                            $years[$i] = $i;
                        }
                        return $years;
                    })
                    ->default(now()->year)
                    ->live(),
            ]);
    }

    public function table(Table $table): Table
    {
        $selectedMonth = $this->selected_month ?? now()->month;
        $selectedYear = $this->selected_year ?? now()->year;

        return $table
            ->query(Attendance::query()
                ->whereMonth('created_at', $selectedMonth)
                ->whereYear('created_at', $selectedYear)
                ->selectRaw('user_id, count(*) as masuk, sum(is_late) as terlambat, sum(is_overtime) as lembur')
                ->groupBy('user_id')
            )
            ->columns([
                TextColumn::make('user.name')->label('Nama Karyawan'),
                TextColumn::make('masuk')->label('Hari Masuk'),
                TextColumn::make('terlambat')->label('Hari Terlambat'),
                TextColumn::make('lembur')->label('Jam Lembur'),
            ])
            ->heading('Laporan Absensi Karyawan');
    }

    protected function getActions(): array
    {
        return [
            \Filament\Pages\Actions\Action::make('exportPdf')
                ->label('Export ke PDF')
                ->color('primary')
                ->icon('heroicon-o-arrow-down-tray')
                ->action('generatePdf'),
        ];
    }

    public function generatePdf()
    {
        // Ambil data absensi menggunakan metode 'table'
        $attendances = $this->table(Table::make($this))->getRecords();
        
        // Ambil data pendapatan menggunakan metode 'getDailyIncomes'
        $incomes = $this->getDailyIncomes();

        // Persiapan data untuk dikirim ke view
        $data = [
            'month_name' => Carbon::create(null, $this->selected_month)->locale('id')->monthName,
            'year' => $this->selected_year,
            'attendances' => $attendances,
            'incomes' => $incomes,
        ];

        // Buat PDF dari view Blade
        $pdf = Pdf::loadView('pdf.monthly_report', $data);

        // Kembalikan PDF untuk diunduh
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'Laporan_Bulanan_' . now()->format('Y-m') . '.pdf');
    }

    public function getDailyIncomes()
    {
        $selectedMonth = $this->selected_month ?? now()->month;
        $selectedYear = $this->selected_year ?? now()->year;

        return DailyIncome::query()
            ->whereMonth('created_at', $selectedMonth)
            ->whereYear('created_at', $selectedYear)
            ->get();
    }
}
