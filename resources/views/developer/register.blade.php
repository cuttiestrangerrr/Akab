<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Jadi Developer - AkabDev</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-neutral-900 text-white font-sans min-h-screen flex flex-col items-center justify-center">

    <div class="w-full max-w-lg bg-neutral-800 p-8 rounded-2xl shadow-2xl border border-neutral-700">
        <div class="text-center mb-8">
            <img src="{{ asset('gambar/logo.png') }}" class="h-16 mx-auto mb-4" alt="Akab Logo">
            <h1 class="text-2xl font-bold bg-gradient-to-r from-red-700 to-red-800 bg-clip-text text-transparent">
                Bergabung sebagai Developer
            </h1>
            <p class="text-neutral-400 mt-2 text-sm">
                Tawarkan jasa dan karya kreatifmu kepada ribuan klien potensial.
            </p>
        </div>

        <form action="{{ route('developer.register.action') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="specialization" class="block text-sm font-medium text-neutral-300 mb-2">Spesialisasi Utama</label>
                <input type="text" id="specialization" name="specialization" 
                       class="w-full px-4 py-3 rounded-lg bg-neutral-700 border border-neutral-600 text-white focus:ring-2 focus:ring-red-500 focus:border-transparent outline-none transition"
                       placeholder="Contoh: Web Developer, UI/UX Designer, 3D Artist"
                       value="{{ old('specialization') }}" required>
                @error('specialization')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-neutral-300 mb-2">Ceritakan Tentang Diri Anda</label>
                <textarea id="description" name="description" rows="4"
                          class="w-full px-4 py-3 rounded-lg bg-neutral-700 border border-neutral-600 text-white focus:ring-2 focus:ring-red-500 focus:border-transparent outline-none transition"
                          placeholder="Jelaskan pengalaman, skill, dan apa yang bisa Anda tawarkan..."
                          required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" 
                    class="w-full py-3 px-4 bg-gradient-to-r from-red-700 to-red-800 hover:from-red-500 hover:to-red-700 text-white font-bold rounded-lg shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                Mulai Karir Developer Saya
            </button> <!-- Fixed typo from text-whitea to text-white -->

            <div class="text-center mt-6">
                <a href="{{ url('/') }}" class="text-sm text-neutral-500 hover:text-white transition">Kembali ke Beranda</a>
            </div>
        </form>
    </div>

</body>
</html>
