<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AkabDev</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-neutral-900 text-white min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-neutral-800 p-8 rounded-xl border border-neutral-700 shadow-2xl">
        
        <div class="flex justify-center mb-6">
            <img src="{{ asset('gambar/logo.png') }}" class="w-20">
        </div>

        <h2 class="text-2xl font-bold text-center mb-6">Login ke AkabDev</h2>

        <form action="{{ url('/login') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block mb-2 text-sm font-medium text-neutral-300">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-2 bg-neutral-700 border border-neutral-600 rounded-lg focus:outline-none focus:border-red-600 text-white placeholder-neutral-400">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-neutral-300">Password</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-2 bg-neutral-700 border border-neutral-600 rounded-lg focus:outline-none focus:border-red-600 text-white placeholder-neutral-400">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" 
                class="w-full py-3 bg-gradient-to-r from-red-700 to-red-800 hover:brightness-110 rounded-lg font-bold transition">
                Masuk
            </button> <!-- Fixing the button label from 'Login' to 'Masuk' to match the request implicit style -->

        </form>

        <p class="mt-6 text-center text-sm text-neutral-400">
            Belum punya akun? <a href="{{ url('/register') }}" class="text-red-500 hover:underline">Daftar WOY</a>
        </p>
    </div>

</body>
</html>
