<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Absensi Karyawan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --color-bg-light: #f3f4f6;
            --color-bg-dark: #111827;
            --color-card-bg-light: #ffffff;
            --color-card-bg-dark: #1f2937;
            --color-text-light: #1f2937;
            --color-text-dark: #e5e7eb;
            --color-primary: #4f46e5;
            --color-primary-hover: #4338ca;
            --color-success: #10b981;
            --color-success-hover: #059669;
            --color-error: #ef4444;
            --color-error-text: #991b1b;
            --color-info-text-light: #6b7280;
            --color-info-text-dark: #9ca3af;
            --color-table-header-light: #f9fafb;
            --color-table-header-dark: #374151;
            --color-border-light: #e5e7eb;
            --color-border-dark: #374151;
            --transition-speed: 0.3s;
        }

        html.light {
            background-color: var(--color-bg-light);
            color: var(--color-text-light);
        }

        html.dark {
            background-color: var(--color-bg-dark);
            color: var(--color-text-dark);
        }

        body.attendance-page {
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 2rem;
            transition: background-color var(--transition-speed), color var(--transition-speed);
            gap: 2rem;
        }

        .card {
            background-color: var(--color-card-bg-light);
            border-radius: 1rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            padding: 2.5rem;
            transition: background-color var(--transition-speed), color var(--transition-speed);
        }

        html.dark .card {
            background-color: var(--color-card-bg-dark);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2);
        }

        .attendance-form-card {
            width: 100%;
            max-width: 400px;
        }

        .history-card {
            width: 100%;
            max-width: 700px;
        }
        
        h1, h2 {
            font-weight: 700;
            text-align: center;
            color: inherit;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        h2 {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #34d399;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #f87171;
        }

        html.dark .alert-success {
            background-color: #064e3b;
            color: #a7f3d0;
            border-color: #10b981;
        }

        html.dark .alert-error {
            background-color: #7f1d1d;
            color: #fca5a5;
            border-color: #f87171;
        }

        .attendance-info {
            text-align: center;
            margin-bottom: 2rem;
            line-height: 1.6;
            color: var(--color-info-text-light);
        }

        html.dark .attendance-info {
            color: var(--color-info-text-dark);
        }

        .attendance-info p {
            margin: 0;
            font-size: 1rem;
        }

        .button-group {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .button-group form {
            margin-bottom: 0;
        }

        .action-btn {
            width: 100%;
            padding: 0.75rem;
            font-weight: 700;
            color: white;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color var(--transition-speed), box-shadow var(--transition-speed);
        }

        .checkin-btn {
            background-color: var(--color-primary);
        }
        
        .checkin-btn:hover {
            background-color: var(--color-primary-hover);
        }

        .checkout-btn {
            background-color: var(--color-success);
        }
        
        .checkout-btn:hover {
            background-color: var(--color-success-hover);
        }
        
        /* Table Styles for Desktop */
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 0.75rem;
        }
        
        th, td {
            padding: 0.75rem 1rem;
            text-align: left;
            border-radius: 0.5rem;
            background-color: var(--color-bg-light);
            transition: background-color var(--transition-speed);
        }
        
        html.dark th, html.dark td {
            background-color: var(--color-table-header-dark);
        }

        th {
            font-weight: 700;
            color: var(--color-text-light);
            background-color: var(--color-table-header-light);
        }

        html.dark th {
            color: var(--color-text-dark);
            background-color: var(--color-table-header-dark);
        }
        
        tbody tr:hover td {
            background-color: #e2e8f0;
        }

        html.dark tbody tr:hover td {
            background-color: #2d3748;
        }

        .empty-row td {
            text-align: center;
            color: var(--color-info-text-light);
        }
        
        html.dark .empty-row td {
            color: var(--color-info-text-dark);
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 1.5rem;
            color: var(--color-info-text-light);
        }
        
        html.dark .pagination {
            color: var(--color-info-text-dark);
        }

        .logout-btn {
            display: block;
            text-align: center;
            width: 100%;
            font-size: 0.9rem;
            color: var(--color-error);
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
            margin-top: 2rem;
            transition: color var(--transition-speed);
        }
        
        .logout-btn:hover {
            text-decoration: underline;
            color: var(--color-error-text);
        }

        html.dark .logout-btn {
            color: #fca5a5;
        }

        html.dark .logout-btn:hover {
            color: #f87171;
        }
        
        .app-info-text {
            text-align: center;
            font-size: 0.75rem;
            color: var(--color-info-text-light);
            margin-top: 1rem;
        }

        html.dark .app-info-text {
            color: var(--color-info-text-dark);
        }
        
        .theme-toggle {
            position: fixed;
            top: 1.5rem;
            right: 1.5rem;
            background-color: var(--color-card-bg-light);
            border: none;
            border-radius: 9999px;
            width: 2.5rem;
            height: 2.5rem;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color var(--transition-speed), box-shadow var(--transition-speed);
            z-index: 1000;
        }

        html.dark .theme-toggle {
            background-color: var(--color-card-bg-dark);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }
        
        .theme-toggle svg {
            width: 1.25rem;
            height: 1.25rem;
            fill: var(--color-text-light);
            transition: fill var(--transition-speed);
        }
        
        html.dark .theme-toggle svg {
            fill: var(--color-text-dark);
        }
        
        /* Responsive styles for Mobile */
        @media (max-width: 1024px) {
            body.attendance-page {
                flex-direction: column;
                align-items: center;
                padding: 1.5rem;
            }
            .attendance-form-card, .history-card {
                max-width: 100%;
                width: 100%;
                padding: 1.5rem;
            }
        }

        @media (max-width: 600px) {
            h1 {
                font-size: 1.75rem;
            }

            h2 {
                font-size: 1.25rem;
            }
            
            table {
                display: block;
                border-spacing: 0;
            }

            thead {
                display: none;
            }

            tbody, tr, td {
                display: block;
                width: 100%;
                box-sizing: border-box;
            }

            tr {
                margin-bottom: 1rem;
                padding: 1rem;
                border-radius: 0.5rem;
                background-color: var(--color-card-bg-light);
                box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            }
            html.dark tr {
                background-color: var(--color-card-bg-dark);
            }

            td {
                text-align: right;
                padding: 0.5rem 1rem;
                border-bottom: 1px solid var(--color-border-light);
            }
            
            html.dark td {
                border-bottom: 1px solid var(--color-border-dark);
            }

            td:last-child {
                border-bottom: none;
            }

            td::before {
                content: attr(data-label);
                font-weight: 700;
                float: left;
                color: var(--color-text-light);
            }

            html.dark td::before {
                color: var(--color-text-dark);
            }
            
            .empty-row {
                background-color: transparent;
                box-shadow: none;
                margin-bottom: 0;
                padding: 0;
            }

            .empty-row td {
                text-align: center;
                border-bottom: none;
            }
        }
    </style>
</head>
<body class="attendance-page">
    <button class="theme-toggle" aria-label="Toggle dark mode" title="Toggle dark mode" id="theme-toggle">
        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
            <path d="M12 3a9 9 0 0 0 0 18 9 9 0 0 0 0-18zm0 16a7 7 0 0 1 0-14 7 7 0 0 1 0 14z"/>
        </svg>
    </button>
    <div class="attendance-form-card card">
        <h1>Absensi Karyawan</h1>

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="attendance-info">
            <p>Halo, {{ Auth::user()->name }}!</p>
            <p>Tanggal: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p id="current-time">Waktu: {{ \Carbon\Carbon::now()->format('H:i:s') }}</p>
        </div>

        <div class="button-group">
            @if (!$todayAttendance)
                <form action="{{ route('attendance.checkin') }}" method="POST">
                    @csrf
                    <button type="submit" class="action-btn checkin-btn">Check-in Sekarang</button>
                </form>
            @elseif ($todayAttendance && !$todayAttendance->check_out_time)
                <form action="{{ route('attendance.checkout') }}" method="POST">
                    @csrf
                    <button type="submit" class="action-btn checkout-btn">Check-out Sekarang</button>
                </form>
            @else
                <div class="attendance-info">
                    <p>Anda telah Check-in dan Check-out hari ini.</p>
                    <p>Check-in: {{ $todayAttendance->check_in_time->format('H:i:s') }}</p>
                    <p>Check-out: {{ $todayAttendance->check_out_time->format('H:i:s') }}</p>
                </div>
            @endif
        </div>
        
        <form action="{{ route('logout') }}" method="POST" style="text-align:center;">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
        <p class="app-info-text">Version 0.8 Alpha</p>
    </div>

    <div class="history-card card">
        <h2>Riwayat Absensi Anda</h2>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Lembur</th>
                    <th>Terlambat</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($attendances as $attendance)
                    <tr>
                        <td data-label="Tanggal">{{ $attendance->check_in_time->translatedFormat('d M Y') }}</td>
                        <td data-label="Check-in">{{ $attendance->check_in_time->format('H:i:s') }}</td>
                        <td data-label="Check-out">
                            {{ $attendance->check_out_time ? $attendance->check_out_time->format('H:i:s') : 'Belum Check-out' }}
                        </td>
                        <td data-label="Lembur">{{ $attendance->is_overtime ? 'Ya' : 'Tidak' }}</td>
                        <td data-label="Terlambat">{{ $attendance->is_late ? 'Ya' : 'Tidak' }}</td>
                    </tr>
                @empty
                    <tr class="empty-row">
                        <td colspan="5">Belum ada riwayat absensi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">
            {{ $attendances->links() }}
        </div>
    </div>

    <script>
        function updateTime() {
            const now = new Date();
            document.getElementById('current-time').innerText = 'Waktu: ' + now.toLocaleTimeString('id-ID');
        }
        setInterval(updateTime, 1000);

        const themeToggleBtn = document.getElementById('theme-toggle');
        const htmlElement = document.documentElement;

        const savedTheme = localStorage.getItem('theme') || 'light';
        htmlElement.classList.add(savedTheme);

        function updateToggleIcon(theme) {
            const svg = themeToggleBtn.querySelector('svg');
            if (theme === 'dark') {
                svg.innerHTML = '<path d="M21.64 13.64a9 9 0 1 1-11.28-11.28 7 7 0 0 0 11.28 11.28z"/>';
            } else {
                svg.innerHTML = '<path d="M12 3a9 9 0 0 0 0 18 9 9 0 0 0 0-18zm0 16a7 7 0 0 1 0-14 7 7 0 0 1 0 14z"/>';
            }
        }
        updateToggleIcon(savedTheme);

        themeToggleBtn.addEventListener('click', () => {
            const currentTheme = htmlElement.classList.contains('light') ? 'light' : 'dark';
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            htmlElement.classList.remove('light', 'dark');
            htmlElement.classList.add(newTheme);
            localStorage.setItem('theme', newTheme);
            updateToggleIcon(newTheme);
        });
    </script>
</body>
</html>