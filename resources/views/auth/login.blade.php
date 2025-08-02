<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
    {{-- <link href="{{ asset('login.css') }}" rel="stylesheet" /> --}}
</head>
<style>
    body.login-page {
    min-height: 100vh;
    background: linear-gradient(90deg, #7c3aed 0%, #4f46e5 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Inter', sans-serif;
    margin: 0;
    padding: 0;
}

.login-card {
    background-color: #ffffff;
    border-radius: 0.5rem;
    box-shadow: 0 10px 15px -3px rgba(124, 58, 237, 0.4), 0 4px 6px -2px rgba(79, 70, 229, 0.1);
    max-width: 400px;
    width: 100%;
    padding: 2rem;
    box-sizing: border-box;
}

.login-card h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    text-align: center;
    margin-bottom: 1.5rem;
}

.login-card label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.login-card input[type="email"],
.login-card input[type="password"] {
    width: 100%;
    padding: 0.5rem 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    box-shadow: inset 0 1px 2px rgb(0 0 0 / 0.05);
    font-size: 1rem;
    color: #111827;
    margin-bottom: 1rem;
    box-sizing: border-box;
}

.login-card input[type="checkbox"] {
    width: auto;
    margin-right: 0.5rem;
}

.login-card .remember-label {
    font-size: 0.875rem;
    color: #4b5563;
    vertical-align: middle;
}

.login-card .forgot-password {
    font-size: 0.875rem;
    color: #7c3aed;
    text-decoration: none;
    font-weight: 600;
}

.login-card .forgot-password:hover {
    text-decoration: underline;
}

.login-card button[type="submit"] {
    background-color: #7c3aed;
    color: white;
    font-weight: 600;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 0.375rem;
    cursor: pointer;
    width: 100%;
    font-size: 1rem;
    transition: background-color 0.3s ease;
}

.login-card button[type="submit"]:hover {
    background-color: #6d28d9;
}

@media (max-width: 480px) {
    .login-card {
        padding: 1.5rem;
        margin: 1rem;
    }
}
</style>
<body class="login-page">
    <div class="login-card">
        <img src="https://via.placeholder.com/150x50?text=Logo" alt="Logo" style="display: block; margin: 0 auto 1rem; max-width: 150px; height: auto;">
        {{-- <img src="{{ asset('images/your-logo.png') }}" alt="Logo"> --}}
        <h2>Sign in to your account</h2>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
                @error('email')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" />
                @error('password')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit">Log in</button>
            </div>
        </form>
    </div>
</body>
</html>
