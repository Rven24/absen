<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Absensi Karyawan</title>
    <style>
        :root {
            --color-bg-light: #f9fafb;
            --color-bg-dark: #1f2937;
            --color-card-bg-light: #ffffff;
            --color-card-bg-dark: #374151;
            --color-text-light: #1f2937;
            --color-text-dark: #f3f4f6;
            --color-primary: #7c3aed;
            --color-primary-hover: #6d28d9;
            --color-success-bg: #dcfce7;
            --color-success-border: #22c55e;
            --color-success-text: #166534;
            --color-error-bg: #fee2e2;
            --color-error-border: #ef4444;
            --color-error-text: #b91c1c;
            --color-checkin-bg: var(--color-primary);
            --color-checkin-hover: var(--color-primary-hover);
            --color-checkout-bg: #10b981;
            --color-checkout-hover: #059669;
            --color-table-header-bg-light: #f3f4f6;
            --color-table-header-bg-dark: #4b5563;
            --color-table-border-light: #e5e7eb;
            --color-table-border-dark: #6b7280;
            --color-table-text-light: #374151;
            --color-table-text-dark: #d1d5db;
            --color-pagination-text-light: #374151;
            --color-pagination-text-dark: #d1d5db;
            --color-logout-text-light: #dc2626;
            --color-logout-text-dark: #f87171;
            --color-logout-hover-light: #b91c1c;
            --color-logout-hover-dark: #ef4444;
            --color-info-text-light: #4b5563;
            --color-info-text-dark: #d1d5db;
            --color-app-info-text-light: #6b7280;
            --color-app-info-text-dark: #9ca3af;
            --transition-speed: 0.3s;
        }

        html.light {
            background: var(--color-bg-light);
            color: var(--color-text-light);
        }

        html.dark {
            background: var(--color-bg-dark);
            color: var(--color-text-dark);
        }

        body.attendance-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            transition: background-color var(--transition-speed), color var(--transition-speed);
        }

        .attendance-card {
            background-color: var(--color-card-bg-light);
            border-radius: 0.75rem;
            box-shadow: 0 10px 20px rgba(124, 58, 237, 0.25);
            max-width: 650px;
            width: 100%;
            padding: 2.5rem 3rem;
            box-sizing: border-box;
            color: var(--color-text-light);
            transition: background-color var(--transition-speed), color var(--transition-speed), box-shadow var(--transition-speed);
        }

        html.dark .attendance-card {
            background-color: var(--color-card-bg-dark);
            color: var(--color-text-dark);
            box-shadow: 0 10px 20px rgba(124, 58, 237, 0.6);
        }

        .attendance-card h1, .attendance-card h2 {
            font-weight: 800;
            text-align: center;
            margin-bottom: 1.75rem;
            color: inherit;
        }

        .attendance-card h1 {
            font-size: 2rem;
        }

        .attendance-card h2 {
            font-size: 1.5rem;
        }

        .alert-success {
            background-color: var(--color-success-bg);
            border: 1px solid var(--color-success-border);
            color: var(--color-success-text);
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.25rem;
            font-weight: 600;
            box-shadow: 0 2px 6px rgba(34, 197, 94, 0.3);
            transition: background-color var(--transition-speed), color var(--transition-speed);
        }

        .alert-error {
            background-color: var(--color-error-bg);
            border: 1px solid var(--color-error-border);
            color: var(--color-error-text);
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.25rem;
            font-weight: 600;
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.3);
            transition: background-color var(--transition-speed), color var(--transition-speed);
        }

        .attendance-info {
            text-align: center;
            margin-bottom: 1.75rem;
            color: var(--color-info-text-light);
            transition: color var(--transition-speed);
        }

        html.dark .attendance-info {
            color: var(--color-info-text-dark);
        }

        .attendance-info p {
            margin: 0.3rem 0;
            font-size: 1.1rem;
        }

        button.checkin-btn, button.checkout-btn {
            width: 100%;
            padding: 0.85rem;
            font-weight: 700;
            color: white;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 1.1rem;
            transition: background-color var(--transition-speed), box-shadow var(--transition-speed);
            box-shadow: 0 4px 8px rgba(124, 58, 237, 0.4);
        }

        button.checkin-btn {
            background-color: var(--color-checkin-bg);
        }

        button.checkin-btn:hover {
            background-color: var(--color-checkin-hover);
            box-shadow: 0 6px 12px rgba(109, 40, 217, 0.6);
        }

        button.checkout-btn {
            background-color: var(--color-checkout-bg);
            box-shadow: 0 4px 8px rgba(16, 185, 129, 0.4);
        }

        button.checkout-btn:hover {
            background-color: var(--color-checkout-hover);
            box-shadow: 0 6px 12px rgba(5, 150, 105, 0.6);
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 0.5rem;
            margin-bottom: 1.5rem;
            transition: color var(--transition-speed);
        }

        thead {
            background-color: var(--color-table-header-bg-light);
            border-radius: 0.5rem;
        }

        html.dark thead {
            background-color: var(--color-table-header-bg-dark);
        }

        th, td {
            padding: 0.85rem 1.25rem;
            text-align: left;
            color: var(--color-table-text-light);
            background-color: var(--color-card-bg-light);
            border-bottom: none;
            transition: background-color var(--transition-speed), color var(--transition-speed);
        }

        html.dark th, html.dark td {
            color: var(--color-table-text-dark);
            background-color: var(--color-card-bg-dark);
        }

        tbody tr {
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: background-color var(--transition-speed);
        }

        tbody tr:hover {
            background-color: #e0d7f9;
        }

        html.dark tbody tr:hover {
            background-color: #5b4b8a;
        }

        .pagination {
            text-align: center;
            margin-top: 1.25rem;
            color: var(--color-pagination-text-light);
            transition: color var(--transition-speed);
        }

        html.dark .pagination {
            color: var(--color-pagination-text-dark);
        }

        .logout-btn {
            display: inline-block;
            margin-top: 1.25rem;
            text-align: center;
            color: var(--color-logout-text-light);
            font-size: 0.9rem;
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
            transition: color var(--transition-speed);
        }

        .logout-btn:hover {
            color: var(--color-logout-hover-light);
            text-decoration: underline;
        }

        html.dark .logout-btn {
            color: var(--color-logout-text-dark);
        }

        html.dark .logout-btn:hover {
            color: var(--color-logout-hover-dark);
        }

        .app-info-text {
            text-align: center;
            color: var(--color-app-info-text-light);
            font-size: 0.8rem;
            margin-top: 0.75rem;
            transition: color var(--transition-speed);
        }

        html.dark .app-info-text {
            color: var(--color-app-info-text-dark);
        }

        /* Theme toggle button */
        .theme-toggle {
            position: fixed;
            top: 1rem;
            right: 1rem;
            background: var(--color-card-bg-light);
            border: none;
            border-radius: 9999px;
            width: 3rem;
            height: 3rem;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(124, 58, 237, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color var(--transition-speed), box-shadow var(--transition-speed);
            z-index: 1000;
        }

        html.dark .theme-toggle {
            background: var(--color-card-bg-dark);
            box-shadow: 0 2px 6px rgba(124, 58, 237, 0.7);
        }

        .theme-toggle svg {
            width: 1.5rem;
            height: 1.5rem;
            fill: var(--color-primary);
            transition: fill var(--transition-speed);
        }

        html.dark .theme-toggle svg {
            fill: var(--color-text-dark);
        }

        /* Responsive styles */
        @media (max-width: 640px) {
            .attendance-card {
                padding: 1.5rem 1.5rem;
                max-width: 100%;
                margin: 1rem;
            }

            .attendance-card h1 {
                font-size: 1.5rem;
            }

            .attendance-card h2 {
                font-size: 1.125rem;
            }

            .attendance-info p {
                font-size: 1rem;
            }

            button.checkin-btn, button.checkout-btn {
                font-size: 1rem;
                padding: 0.65rem;
            }

            table {
                font-size: 0.875rem;
            }

            th, td {
                padding: 0.5rem 0.75rem;
            }

            .pagination {
                font-size: 0.875rem;
            }

            .logout-btn {
                font-size: 0.8rem;
            }

            .app-info-text {
                font-size: 0.7rem;
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
    <div class="attendance-card">
        <h1>Absensi Karyawan</h1>

        @if (session('success'))
            <div class="alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert-error" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="attendance-info">
            <p>Halo, {{ Auth::user()->name }}!</p>
            <p>Tanggal: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p id="current-time">Waktu: {{ \Carbon\Carbon::now()->format('H:i:s') }}</p>
        </div>

        @if (!$todayAttendance)
            <form action="{{ route('attendance.checkin') }}" method="POST" class="mb-6">
                @csrf
                <button type="submit" class="checkin-btn">Check-in Sekarang</button>
            </form>
        @elseif ($todayAttendance && !$todayAttendance->check_out_time)
            <form action="{{ route('attendance.checkout') }}" method="POST" class="mb-6">
                @csrf
                <button type="submit" class="checkout-btn">Check-out Sekarang</button>
            </form>
        @else
            <div class="attendance-info">
                <p>Anda telah Check-in dan Check-out hari ini.</p>
                <p>Check-in: {{ $todayAttendance->check_in_time->format('H:i:s') }}</p>
                <p>Check-out: {{ $todayAttendance->check_out_time->format('H:i:s') }}</p>
                <p>Lembur: {{ $todayAttendance->is_overtime ? 'Ya' : 'Tidak' }}</p>
            </div>
        @endif

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
                        <td>{{ $attendance->check_in_time->translatedFormat('d M Y') }}</td>
                        <td>{{ $attendance->check_in_time->format('H:i:s') }}</td>
                        <td>
                            {{ $attendance->check_out_time ? $attendance->check_out_time->format('H:i:s') : 'Belum Check-out' }}
                        </td>
                        <td>{{ $attendance->is_overtime ? 'Ya' : 'Tidak' }}</td>
                        <td>{{ $attendance->is_late ? 'Ya' : 'Tidak' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; color:#6b7280;">Belum ada riwayat absensi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">
            {{ $attendances->links() }}
        </div>

        <form action="{{ route('logout') }}" method="POST" style="text-align:center;">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
        <p class="app-info-text">Version 0.8 Alpha </p>
    </div>

    <script>
        // Update current time every second
        function updateTime() {
            const now = new Date();
            document.getElementById('current-time').innerText = 'Waktu: ' + now.toLocaleTimeString('id-ID');
        }
        setInterval(updateTime, 1000);

        // Theme toggle logic
        const themeToggleBtn = document.getElementById('theme-toggle');
        const htmlElement = document.documentElement;

        // Load saved theme from localStorage or default to light
        const savedTheme = localStorage.getItem('theme') || 'light';
        htmlElement.classList.remove('light', 'dark');
        htmlElement.classList.add(savedTheme);

        // Update toggle icon based on theme
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
            let currentTheme = htmlElement.classList.contains('light') ? 'light' : 'dark';
            let newTheme = currentTheme === 'light' ? 'dark' : 'light';
            htmlElement.classList.remove('light', 'dark');
            htmlElement.classList.add(newTheme);
            localStorage.setItem('theme', newTheme);
            updateToggleIcon(newTheme);
        });
    </script>
</body>
</html>
