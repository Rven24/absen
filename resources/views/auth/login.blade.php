<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - App Anda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Optimasi tambahan untuk responsif */
        @media (max-width: 640px) {
            .max-w-md {
                max-width: 100%;
            }
            .p-8 {
                padding: 1.5rem; /* Mengurangi padding di layar kecil */
            }
            .text-3xl {
                font-size: 2rem; /* Mengurangi ukuran font judul */
            }
            .text-sm {
                font-size: 0.875rem; /* Mengurangi ukuran font teks kecil */
            }
            .space-y-6 > * + * {
                margin-top: 1.25rem !important; /* Menyesuaikan jarak antar elemen */
            }
        }
    </style>
</head>
<body>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 p-6">
        <div class="max-w-md w-full bg-white rounded-xl shadow-2xl p-8 transform transition duration-500 hover:scale-105">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900">Karyanusa Printing</h1>
                <p class="text-gray-500 mt-2">Login Untuk Melakukan Absen</p>
            </div>
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input id="email" name="email" type="email" required autofocus autocomplete="username" placeholder="you@example.com"
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-300 ease-in-out" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" required autocomplete="current-password" placeholder="••••••••"
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-300 ease-in-out" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
                </div>
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember_me" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" />
                        <label for="remember_me" class="ml-2 block text-gray-900">Remember me</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="font-medium text-indigo-600 hover:text-indigo-500 transition duration-300 ease-in-out">Forgot your password?</a>
                    @endif
                </div>
                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300 ease-in-out">
                        Sign In
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>