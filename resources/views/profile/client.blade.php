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
                
                <div>
                    <h1 class="text-3xl font-bold">{{ $user->name }}</h1>
                    <p class="text-white/80">{{ $user->email }}</p>
                    <div class="mt-2">
                        <span class="inline-block bg-white/20 px-3 py-1 rounded-full text-sm font-semibold">
                            User
                        </span>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500 text-green-500 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Profile Info -->
        <div class="bg-neutral-800 rounded-xl p-6 mb-6 border border-neutral-700">
            <h2 class="text-xl font-semibold mb-4">Informasi Profil</h2>
            <div class="space-y-3 text-neutral-300">
                <div class="flex items-center">
                    <span class="font-medium w-32">Nama:</span>
                    <span>{{ $user->name }}</span>
                </div>
                <div class="flex items-center">
                    <span class="font-medium w-32">Email:</span>
                    <span>{{ $user->email }}</span>
                </div>
                <div class="flex items-center">
                    <span class="font-medium w-32">Role:</span>
                    <span class="text-red-400">User</span>
                </div>
            </div>
        </div>

        <!-- Upgrade to Developer -->
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

        <!-- Actions -->
        <div class="flex space-x-4">
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
