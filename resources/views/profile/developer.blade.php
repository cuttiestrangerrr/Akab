<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Developer - AkabDev</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-neutral-900 text-white font-sans min-h-screen">
    
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Header -->
        <div class="bg-gradient-to-r from-red-700 to-red-800 rounded-xl p-8 mb-6 shadow-2xl">
            <div class="flex items-center space-x-6">
                @if($user->profile_photo)
                    <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                         alt="Profile Photo" 
                         class="w-24 h-24 rounded-full border-4 border-white shadow-lg object-cover">
                @else
                    <div class="w-24 h-24 rounded-full bg-neutral-700 border-4 border-white shadow-lg flex items-center justify-center">
                        <svg class="w-12 h-12 text-neutral-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                @endif
                
                <div class="flex-1">
                    <h1 class="text-3xl font-bold">{{ $user->name }}</h1>
                    <p class="text-white/80">{{ $user->specialization }}</p>
                    <div class="mt-2 flex items-center space-x-3">
                        <span class="inline-block bg-white/20 px-3 py-1 rounded-full text-sm font-semibold">
                            💻 Developer
                        </span>
                        @if($user->average_rating > 0)
                            <span class="text-yellow-400 flex items-center">
                                ⭐ {{ number_format($user->average_rating, 1) }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500 text-green-500 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Developer Info -->
        <div class="bg-neutral-800 rounded-xl p-6 mb-6 border border-neutral-700">
            <h2 class="text-xl font-semibold mb-4">Tentang Developer</h2>
            <div class="space-y-3 text-neutral-300">
                <div class="flex items-start">
                    <span class="font-medium w-32">Spesialisasi:</span>
                    <span>{{ $user->specialization }}</span>
                </div>
                <div class="flex items-start">
                    <span class="font-medium w-32">Deskripsi:</span>
                    <span>{{ $user->description ?? 'Belum ada deskripsi' }}</span>
                </div>
                <div class="flex items-start">
                    <span class="font-medium w-32">Email:</span>
                    <span>{{ $user->email }}</span>
                </div>
                @if($user->average_rating > 0)
                    <div class="flex items-center">
                        <span class="font-medium w-32">Rating:</span>
                        <span class="text-yellow-400">⭐ {{ number_format($user->average_rating, 1) }}/5.0</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-neutral-800 rounded-xl p-6 border border-neutral-700 text-center">
                <div class="text-3xl font-bold text-red-500">{{ $user->services()->count() }}</div>
                <div class="text-neutral-400 text-sm mt-1">Jasa Aktif</div>
            </div>
            <div class="bg-neutral-800 rounded-xl p-6 border border-neutral-700 text-center">
                <div class="text-3xl font-bold text-red-400">{{ $user->projectsAsDeveloper()->count() }}</div>
                <div class="text-neutral-400 text-sm mt-1">Proyek Selesai</div>
            </div>
            <div class="bg-neutral-800 rounded-xl p-6 border border-neutral-700 text-center">
                <div class="text-3xl font-bold text-green-500">{{ $user->ratingsReceived()->count() }}</div>
                <div class="text-neutral-400 text-sm mt-1">Review</div>
            </div>
        </div>

        <!-- Join Community CTA -->
        @if(!$user->isCommunityDeveloper())
            <div class="bg-gradient-to-r from-purple-900/50 to-red-900/50 rounded-xl p-6 mb-6 border border-purple-700/50">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-xl font-bold mb-2 text-red-400">Gabung Komunitas Developer!</h3>
                        <p class="text-neutral-300 mb-4">
                            Berbagi, belajar, dan berkembang bersama komunitas developer se-Indonesia
                        </p>
                        <ul class="space-y-2 text-sm text-neutral-400 mb-4">
                            <li>✨ Posting tips, trik, dan karya Anda</li>
                            <li>✨ Diskusi dan kolaborasi dengan developer lain</li>
                            <li>✨ Tampilkan profil komunitas dengan social links</li>
                            <li>✨ Dapatkan followers dan tingkatkan visibilitas</li>
                        </ul>
                    </div>
                    <div class="flex-shrink-0">
                        <svg class="w-20 h-20 text-red-500/30" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                        </svg>
                    </div>
                </div>
                <a href="{{ route('developer.become.community') }}" 
                   class="inline-block bg-gradient-to-r from-purple-600 to-red-600 hover:from-purple-500 hover:to-red-500 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                    Gabung Komunitas Sekarang
                </a>
            </div>
        @endif

        <!-- Actions -->
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('developer.dashboard') }}" 
               class="bg-gradient-to-r from-red-700 to-red-800 hover:from-red-500 hover:to-red-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                Dashboard Developer
            </a>
            <a href="{{ route('developer.services.index') }}" 
               class="bg-neutral-700 hover:bg-neutral-600 text-white font-semibold py-3 px-6 rounded-lg transition">
                Kelola Jasa
            </a>
            <a href="{{ route('profile.edit') }}" 
               class="bg-neutral-700 hover:bg-neutral-600 text-white font-semibold py-3 px-6 rounded-lg transition">
                Edit Profil
            </a>
            <a href="{{ route('home') }}" 
               class="bg-neutral-800 hover:bg-neutral-700 text-white font-semibold py-3 px-6 rounded-lg border border-neutral-600 transition">
                Kembali ke Beranda
            </a>
        </div>
    </div>

</body>
</html>
