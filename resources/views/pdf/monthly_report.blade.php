<!DOCTYPE html>
<html>
<head>
    <title>Laporan Bulanan</title>
    <style>
        body { font-family: sans-serif; }
        h1, h3 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <h1>Laporan Bulanan</h1>
    <h3>Bulan {{ $month_name }} Tahun {{ $year }}</h3>

    <h2>Laporan Absensi Karyawan</h2>
    <table>
        <thead>
            <tr>
                <th>Nama Karyawan</th>
                <th>Hari Masuk</th>
                <th>Hari Terlambat</th>
                <th>Jam Lembur</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->user->name }}</td>
                    <td>{{ $attendance->masuk }}</td>
                    <td>{{ $attendance->terlambat }}</td>
                    <td>{{ $attendance->lembur }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Laporan Pendapatan Harian</h2>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Pendapatan Harian</th>
            </tr>
        </thead>
        <tbody>
            @foreach($incomes as $income)
                <tr>
                    <td>{{ $income->created_at->format('d F Y') }}</td>
                    <td>Rp{{ number_format($income->amount, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>