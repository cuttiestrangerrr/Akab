<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - AkabDev</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-neutral-900 text-white font-sans min-h-screen">
    
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Header with Profile -->
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
                    <p class="text-white/80">{{ $user->email }}</p>
                    
                    <!-- Role Badges -->
                    <div class="mt-3 flex flex-wrap gap-2">
                        <span class="inline-block bg-white/20 px-3 py-1 rounded-full text-sm font-semibold">
                            👤 User
                        </span>
                        @if($user->isDeveloper())
                            <span class="inline-block bg-red-500/30 px-3 py-1 rounded-full text-sm font-semibold text-red-200">
                                💻 Developer
                            </span>
                        @endif
                        @if($user->isCommunityDeveloper())
                            <span class="inline-block bg-red-500/30 px-3 py-1 rounded-full text-sm font-semibold text-red-200">
                                🌟 Community Developer
                            </span>
                        @endif
                        @if($user->average_rating > 0)
                            <span class="inline-block bg-yellow-500/30 px-3 py-1 rounded-full text-sm font-semibold text-yellow-200">
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

        <!-- Basic Profile Info -->
        <div class="bg-neutral-800 rounded-xl p-6 mb-6 border border-neutral-700">
            <h2 class="text-xl font-semibold mb-4 flex items-center">
                <span class="text-neutral-400 mr-2">👤</span>
                Informasi Akun
            </h2>
            <div class="space-y-3 text-neutral-300">
                <div class="flex items-center">
                    <span class="font-medium w-40 text-neutral-400">Nama:</span>
                    <span>{{ $user->name }}</span>
                </div>
                <div class="flex items-center">
                    <span class="font-medium w-40 text-neutral-400">Email:</span>
                    <span>{{ $user->email }}</span>
                </div>
                <div class="flex items-center">
                    <span class="font-medium w-40 text-neutral-400">Bergabung:</span>
                    <span>{{ $user->created_at->format('d F Y') }}</span>
                </div>
            </div>
        </div>

        <!-- User Activity Section (for all users) -->
        <div class="bg-neutral-800 rounded-xl p-6 mb-6 border border-blue-700/50">
            <h2 class="text-xl font-semibold mb-4 flex items-center">
                <span class="text-blue-500 mr-2">📊</span>
                Aktivitas Saya
            </h2>
            
            <!-- User Quick Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-red-900/30 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-red-400">{{ $user->orders()->count() }}</div>
                    <div class="text-neutral-400 text-sm mt-1">Total Pesanan</div>
                </div>
                <div class="bg-green-900/30 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-green-400">{{ $user->orders()->where('status', 'completed')->count() }}</div>
                    <div class="text-neutral-400 text-sm mt-1">Pesanan Selesai</div>
                </div>
                <div class="bg-amber-900/30 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-red-400">{{ $user->assetPurchases()->count() }}</div>
                    <div class="text-neutral-400 text-sm mt-1">Aset Dibeli</div>
                </div>
                <div class="bg-yellow-900/30 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-yellow-400">{{ $user->ratingsGiven()->count() }}</div>
                    <div class="text-neutral-400 text-sm mt-1">Review Diberikan</div>
                </div>
            </div>
        </div>

        <!-- Developer Info Section (only if developer) -->
        @if($user->isDeveloper())
            <div class="bg-neutral-800 rounded-xl p-6 mb-6 border border-amber-700/50">
                <h2 class="text-xl font-semibold mb-4 flex items-center">
                    <span class="text-amber-500 mr-2">💻</span>
                    Informasi Developer
                </h2>
                <div class="space-y-3 text-neutral-300">
                    <div class="flex items-start">
                        <span class="font-medium w-40 text-neutral-400">Spesialisasi:</span>
                        <span>{{ $user->specialization }}</span>
                    </div>
                    <div class="flex items-start">
                        <span class="font-medium w-40 text-neutral-400">Deskripsi:</span>
                        <span>{{ $user->description ?? 'Belum ada deskripsi' }}</span>
                    </div>
                    @if($user->average_rating > 0)
                        <div class="flex items-center">
                            <span class="font-medium w-40 text-neutral-400">Rating:</span>
                            <span class="text-yellow-400">⭐ {{ number_format($user->average_rating, 1) }}/5.0</span>
                        </div>
                    @endif
                </div>

                <!-- Developer Quick Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                    <div class="bg-neutral-700/50 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-red-400">{{ $user->services()->count() }}</div>
                        <div class="text-neutral-400 text-sm mt-1">Jasa Aktif</div>
                    </div>
                    <div class="bg-neutral-700/50 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-red-400">{{ $user->projectsAsDeveloper()->count() }}</div>
                        <div class="text-neutral-400 text-sm mt-1">Proyek Selesai</div>
                    </div>
                    <div class="bg-neutral-700/50 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-green-400">{{ $user->ratingsReceived()->count() }}</div>
                        <div class="text-neutral-400 text-sm mt-1">Review</div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Community Developer Info Section (only if community developer) -->
        @if($user->isCommunityDeveloper())
            <div class="bg-neutral-800 rounded-xl p-6 mb-6 border border-purple-700/50">
                <h2 class="text-xl font-semibold mb-4 flex items-center">
                    <span class="text-red-500 mr-2">🌟</span>
                    Profil Komunitas
                </h2>
                
                <!-- Social Links -->
                <div class="space-y-3 text-neutral-300 mb-6">
                    @if($user->instagram_link)
                        <div class="flex items-center">
                            <span class="font-medium w-40 text-neutral-400 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073z"/>
                                </svg>
                                Instagram:
                            </span>
                            <a href="{{ $user->instagram_link }}" target="_blank" class="text-pink-400 hover:underline">
                                {{ $user->instagram_link }}
                            </a>
                        </div>
                    @endif
                    @if($user->github_link)
                        <div class="flex items-center">
                            <span class="font-medium w-40 text-neutral-400 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                </svg>
                                GitHub:
                            </span>
                            <a href="{{ $user->github_link }}" target="_blank" class="text-gray-300 hover:underline">
                                {{ $user->github_link }}
                            </a>
                        </div>
                    @endif
                    @if($user->website_link)
                        <div class="flex items-center">
                            <span class="font-medium w-40 text-neutral-400 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm1 16.057v-3.057h2.994c-.059 1.143-.212 2.24-.456 3.279-.823-.12-1.674-.188-2.538-.222zm1.957 2.162c-.499 1.33-1.159 2.497-1.957 3.456v-3.62c.666.028 1.319.081 1.957.164zm-1.957-7.219v-3.015c.868-.034 1.721-.103 2.548-.224.238 1.027.389 2.111.446 3.239h-2.994zm0-5.014v-3.661c.806.969 1.471 2.15 1.971 3.496-.642.084-1.3.137-1.971.165zm2.703-3.267c1.237.496 2.354 1.228 3.29 2.146-.642.234-1.311.442-2.019.607-.344-.992-.775-1.91-1.271-2.753z"/>
                                </svg>
                                Website:
                            </span>
                            <a href="{{ $user->website_link }}" target="_blank" class="text-red-400 hover:underline">
                                {{ $user->website_link }}
                            </a>
                        </div>
                    @endif
                    @if(!$user->instagram_link && !$user->github_link && !$user->website_link)
                        <p class="text-neutral-500 italic">Belum ada social links yang ditambahkan.</p>
                    @endif
                </div>

                <!-- Community Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-neutral-800/50 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-neutral-400">{{ $user->posts()->count() }}</div>
                        <div class="text-neutral-400 text-sm mt-1">Posts</div>
                    </div>
                    <div class="bg-neutral-800/50 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-pink-400">{{ $user->followers()->count() }}</div>
                        <div class="text-neutral-400 text-sm mt-1">Followers</div>
                    </div>
                    <div class="bg-neutral-800/50 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-red-400">{{ $user->follows()->count() }}</div>
                        <div class="text-neutral-400 text-sm mt-1">Following</div>
                    </div>
                </div>
            </div>
        @endif

        <!-- CTA: Become Developer (only for regular users) -->
        @if(!$user->isDeveloper())
            <div class="bg-gradient-to-r from-neutral-800 to-neutral-700 rounded-xl p-6 mb-6 border border-neutral-600">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-xl font-bold mb-2 text-red-400">Ingin Menjadi Developer?</h3>
                        <p class="text-neutral-300 mb-4">
                            Tawarkan jasa Anda, dapatkan klien, dan mulai menghasilkan!
                        </p>
                        <ul class="space-y-2 text-sm text-neutral-400 mb-4">
                            <li>✅ Upload dan kelola jasa Anda</li>
                            <li>✅ Terima order dari klien</li>
                            <li>✅ Akses dashboard developer</li>
                            <li>✅ Dapatkan rating dan review</li>
                            <li>✅ Cuan Mania!!!!!</li>
                        </ul>
                    </div>
                    <div class="flex-shrink-0">
                        <svg class="w-20 h-20 text-red-500/30" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                        </svg>
                    </div>
                </div>
                <a href="{{ route('developer.register') }}" 
                   class="inline-block bg-gradient-to-r from-red-700 to-red-800 hover:from-red-500 hover:to-red-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                    Daftar Jadi Developer Sekarang
                </a>
            </div>
        @endif

        <!-- CTA: Join Community (only for developers who are not community developers) -->
        @if($user->isDeveloper() && !$user->isCommunityDeveloper())
            <div class="bg-gradient-to-r from-purple-900/50 to-red-900/50 rounded-xl p-6 mb-6 border border-purple-700/50">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-xl font-bold mb-2 text-neutral-400">Gabung Komunitas Developer!</h3>
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

        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-4">
            @if($user->isDeveloper())
                <a href="{{ route('developer.dashboard') }}" 
                   class="bg-gradient-to-r from-red-700 to-red-800 hover:from-red-500 hover:to-red-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                    Dashboard Developer
                </a>
                <a href="{{ route('developer.services.index') }}" 
                   class="bg-neutral-700 hover:bg-neutral-600 text-white font-semibold py-3 px-6 rounded-lg transition">
                    Kelola Jasa
                </a>
            @endif
            @if($user->isCommunityDeveloper())
                <a href="{{ route('developer.community') }}" 
                   class="bg-red-700 hover:bg-red-600 text-white font-semibold py-3 px-6 rounded-lg transition">
                    Komunitas
                </a>
            @endif
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
