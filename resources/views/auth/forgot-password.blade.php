<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - App Anda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Optimasi tambahan untuk responsif dan tema */
        :root {
            --color-primary: #4f46e5;
            --color-primary-hover: #4338ca;
            --color-purple: #7c3aed;
            --color-purple-hover: #6d28d9;
        }

        /* Menyesuaikan tombol agar konsisten dengan halaman lain */
        .btn-purple {
            background-color: var(--color-purple);
            transition: background-color 0.3s ease-in-out;
        }
        .btn-purple:hover {
            background-color: var(--color-purple-hover);
        }

        /* Styling card yang konsisten */
        .card {
            background-color: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            width: 100%;
            max-width: 28rem;
        }

        /* Layout untuk menengahkan card */
        .flex-center-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f3f4f6;
            padding: 1.5rem;
        }

        /* Optimasi responsif untuk mobile */
        @media (max-width: 640px) {
            .card {
                padding: 1.5rem;
                max-width: 100%;
            }
            .text-sm {
                font-size: 0.875rem;
            }
            .space-y-4 > * + * {
                margin-top: 1rem !important;
            }
        }
    </style>
</head>
<body class="flex-center-page">
    <div class="card transform transition duration-500 hover:scale-105">

        <div class="text-center mb-6">
            <h1 class="text-2xl font-extrabold text-gray-900">Atur Ulang Kata Sandi</h1>
            <p class="text-gray-500 mt-2 text-sm">Lupa kata sandi Anda? Jangan khawatir.</p>
        </div>

        <div class="mb-4 text-sm text-purple-600">
            Cukup berikan alamat email Anda dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi melalui email, yang akan memungkinkan Anda untuk memilih kata sandi baru.
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('password.email') }}" class="space-y-4 mt-6">
            @csrf
        
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-300 ease-in-out" />
                @if ($errors->has('email'))
                    <div class="mt-2 text-red-500 text-sm">
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>
        
            <div class="mt-6">
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300 ease-in-out">
                    Kirim Tautan Atur Ulang Kata Sandi
                </button>
            </div>
        </form>
    </div>
</body>
</html>