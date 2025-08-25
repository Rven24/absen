<x-filament-panels::page>

    <div class="mt-6">
        {{ $this->form }}
    </div>

    <div class="mt-6">
        {{ $this->table }}
    </div>

    <div class="mt-6">
        <x-filament::card>
            <h3 class="font-bold text-lg mb-4">Laporan Pendapatan Harian</h3>
            <table class="w-full text-left">
                <thead>
                    <tr class="text-gray-600 dark:text-gray-400">
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Pendapatan Tunai</th>
                        <th class="px-4 py-2">Pendapatan Transfer</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->getDailyIncomes() as $income)
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="px-4 py-2">{{ $income->created_at->format('d F Y') }}</td>
                            <td class="px-4 py-2">{{ number_format($income->amount, 0, ',', '.') }} IDR</td>
                            <td class="px-4 py-2">{{ number_format($income->transfer_income, 0, ',', '.') }} IDR</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </x-filament::card>
    </div>
</x-filament-panels::page>