<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AkabDev Center</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans min-h-screen flex flex-col">
    <nav class="nav shadow-md fixed top-0 z-50 w-full bg-white">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">

            <div class="flex items-center gap-2">
                <a href="{{ route('developer.dashboard') }}" class="flex items-center">
                    <img src="{{ asset('gambar/logo.png') }}" width="77" class="mr-3">
                </a>
                <h5 class="text-neutral-300 text-lg font-regular ml-3 border-l border-gray-300 pl-8">
                    Developer Center
                </h5>
            </div>

            <div class="hidden md:flex md:gap-9 md:items-center">
                <a href="{{ url('/chat') }}">
                    <img src="{{ asset('gambar/chat.png') }}" width="24">
                </a>
                <a href="{{ url('/cs') }}">
                    <img src="{{ asset('gambar/cs.png') }}" width="20">
                </a>
                <a href="{{ url('/edu') }}">
                    <img src="{{ asset('gambar/edu.png') }}" width="15">
                </a>

                <div class="relative border-l border-gray-300 pl-8" x-data="{ open: false }">
                    <button @click="open = !open" 
                            @click.outside="open = false" 
                            class="w-10 h-10 bg-gray-200 rounded-full cursor-pointer flex items-center justify-center focus:outline-none">
                        <img src="{{ asset('gambar/logo.png') }}" class="w-6 h-6">
                    </button>

                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-40 bg-white shadow-lg rounded-md border border-gray-200 z-50">
                        <ul class="py-4 text-sm text-gray-700">
                            <li><a href="{{ route('developer.community.profile') }}" class="block px-4 py-2 hover:bg-red-600 hover:text-white transition-colors">Profile</a></li>
                            <li><a href="{{ url('/') }}" class="block px-4 py-2 hover:bg-red-600 hover:text-white transition-colors">Jelajahi Developer</a></li>
                            <li><a href="{{ url('/settings') }}" class="block px-4 py-2 hover:bg-red-600 hover:text-white transition-colors">Settings</a></li>
                            <li><a href="{{ url('/logout') }}" class="block px-4 py-2 hover:bg-red-600 hover:text-white text-red-500 transition-colors">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </nav>

    <div class="w-60 h-full bg-black pt-20 shadow-lg fixed left-0 top-0 ">
    <nav class="flex flex-col gap-2 px-0 h-full">

    <div class="px-2">
        <a href="">
            <div class="flex flex-col items-center text-white px-4 mb-2 bg-neutral-700 rounded-lg py-4">
                <img 
                    src="{{ optional(Auth::user())->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('gambar/logo.png') }}" 
                    alt="Profile" 
                    class="w-20 h-20 rounded-full object-contain shadow-2xl"
                >
                <div class="mt-3 text-center">
                    <p class="text-lg font-regular">{{ optional(Auth::user())->name ?? 'Guest' }}</p>
                    <p class="text-sm text-neutral-400">Rp 5.000.000</p>
                </div>
            </div>
        </a>
    </div>

    <div class="sidemenu flex flex-col gap-4 px-2 flex-1 overflow-y-auto min-h-0">

        <div x-data="{ openPerforma: false }">
            <button 
                @click="openPerforma = !openPerforma"
                class="w-full text-left flex items-center justify-between px-5 py-3 hover:bg-neutral-700 rounded text-white">
                <span>Pesanan</span>
                <span x-text="openPerforma ? '-' : '+'"></span>
            </button>

            <div x-show="openPerforma" x-transition class="ml-4 mt-4 mb-2 flex flex-col gap-2">
                <a href="{{ route('developer.orders') }}" class="block px-4 py-2 text-sm text-white hover:bg-neutral-700 rounded">
                    Pesanan Saya
                </a>
                <a href="{{ url('/jasa/kelola') }}" class="block px-4 py-2 text-sm text-white hover:bg-neutral-700 rounded">
                    Pesanan Berhasil
                </a>
                <a href="{{ url('/jasa/kelola') }}" class="block px-4 py-2 text-sm text-white hover:bg-neutral-700 rounded">
                    Penilaian Pesanan
                </a>
            </div>
        </div>

        <div x-data="{ openJasa: false }">
            <button 
                @click="openJasa = !openJasa"
                class="w-full text-left flex items-center justify-between px-5 py-3 hover:bg-neutral-700 rounded text-white">
                <span>Jasa</span>
                <span x-text="openJasa ? '-' : '+'"></span>
            </button>

            <div x-show="openJasa" x-transition class="ml-4 mt-4 mb-2 flex flex-col gap-2">
                <a href="{{ route('developer.upload') }}" class="block px-4 py-2 text-sm text-white hover:bg-neutral-700 rounded">
                    Upload Jasa
                </a>
                <a href="{{ route('developer.services.index') }}" class="block px-4 py-2 text-sm text-white hover:bg-neutral-700 rounded">
                    Kelola Jasa
                </a>
            </div>
        </div>

        <a href="{{ route('developer.performance') }}"
           class="text-white hover:text-white hover:bg-neutral-700 px-5 py-3 rounded">
           Performa
        </a>

        <div x-data="{ openKomunitas: false }">
            <button 
                @click="openKomunitas = !openKomunitas"
                class="w-full text-left flex items-center justify-between px-5 py-3 hover:bg-neutral-700 rounded text-white">
                <span>Komunitas</span>
                <span x-text="openKomunitas ? '-' : '+'"></span>
            </button>

            <div x-show="openKomunitas" x-transition class="ml-4 mt-4 mb-2 flex flex-col gap-2">
                <a href="{{ route('developer.community') }}" class="block px-4 py-2 text-sm text-white hover:bg-neutral-700 rounded">
                    Beranda Komunitas
                </a>
                <a href="{{ url('/komunitas/postingan') }}" class="block px-4 py-2 text-sm text-white hover:bg-neutral-700 rounded">
                    Buat Postingan
                </a>
                <a href="{{ route('developer.community.profile') }}" class="block px-4 py-2 text-sm text-white hover:bg-neutral-700 rounded">
                    Profil & Postingan Saya
                </a>
            </div>
        </div>

        <div x-data="{ openAset: false }">
            <button 
                @click="openAset = !openAset"
                class="w-full text-left flex items-center justify-between px-5 py-3 hover:bg-neutral-700 rounded text-white">
                <span>Aset</span>
                <span x-text="openAset ? '-' : '+'"></span>
            </button>

            <div x-show="openAset" x-transition class="ml-4 mt-4 mb-2 flex flex-col gap-2">
                <a href="{{ url('/jasa/beranda') }}" class="block px-4 py-2 text-sm text-white hover:bg-neutral-700 rounded">
                    Toko Aset
                </a>
                <a href="{{ url('/jasa/beranda') }}" class="block px-4 py-2 text-sm text-white hover:bg-neutral-700 rounded">
                    Upload Aset
                </a>
                <a href="{{ url('/jasa/kelola') }}" class="block px-4 py-2 text-sm text-white hover:bg-neutral-700 rounded">
                    Kelola Aset
                </a>
                <a href="{{ url('/jasa/kelola') }}" class="block px-4 py-2 text-sm text-white hover:bg-neutral-700 rounded">
                    Aset Saya
                </a>
            </div>
        </div>

        </div>

        <div class="mt-auto px-5 py-4 border-t border-neutral-800">
            <a href="{{ url('/logout') }}" 
               class="flex items-center gap-3 text-red-500 hover:text-red-400 transition font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                </svg>
                Logout
            </a>
        </div>
    </nav>
</div>

<script>
    document.getElementById('menu-toggle').addEventListener('click', () => {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
</script>
</body>
</html>