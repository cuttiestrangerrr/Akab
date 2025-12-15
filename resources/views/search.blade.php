@include('nav.navbar')

<main class="pt-30 bg-neutral-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 py-8">
        
        <!-- Search Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">
                @if($query)
                    Hasil pencarian: "<span class="text-red-400">{{ $query }}</span>"
                @else
                    Semua Layanan
                @endif
            </h1>
            <p class="text-neutral-400">
                Ditemukan {{ $services->count() }} layanan
                @if($developers->count() > 0)
                    dan {{ $developers->count() }} developer
                @endif
            </p>
        </div>

        <!-- Search Form -->
        <div class="bg-neutral-800 rounded-2xl p-6 mb-8 border border-neutral-700">
            <form action="{{ route('search') }}" method="GET" class="space-y-4">
                <div class="flex gap-4">
                    <div class="flex-1">
                        <input type="text" 
                               name="q" 
                               value="{{ $query }}"
                               placeholder="Cari layanan, developer, kategori..."
                               class="w-full px-5 py-3 bg-neutral-700 text-white rounded-xl border border-neutral-600 focus:border-red-500 focus:ring-1 focus:ring-red-500 focus:outline-none">
                    </div>
                    <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-red-700 to-red-800 text-white font-semibold rounded-xl hover:brightness-110 transition">
                        Cari
                    </button>
                </div>
                
                <!-- Category Filter -->
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('search', ['q' => $query]) }}" 
                       class="px-4 py-2 rounded-full text-sm font-medium transition
                              {{ empty($category) ? 'bg-gradient-to-r from-red-700 to-red-800 text-white' : 'bg-neutral-700 text-neutral-300 hover:bg-neutral-600' }}">
                        Semua
                    </a>
                    @foreach($categories as $cat)
                    <a href="{{ route('search', ['q' => $query, 'category' => $cat]) }}" 
                       class="px-4 py-2 rounded-full text-sm font-medium transition
                              {{ $category === $cat ? 'bg-gradient-to-r from-red-700 to-red-800 text-white' : 'bg-neutral-700 text-neutral-300 hover:bg-neutral-600' }}">
                        {{ $cat }}
                    </a>
                    @endforeach
                </div>
            </form>
        </div>

        <!-- Developers Section -->
        @if($developers->count() > 0 && empty($category))
        <div class="mb-10">
            <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                <span class="text-2xl">👨‍💻</span> Developer
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @foreach($developers as $developer)
                <a href="#" class="bg-neutral-800 rounded-xl p-4 border border-neutral-700 hover:border-red-500/50 transition group text-center">
                    <img src="{{ $developer->profile_photo ? asset('storage/' . $developer->profile_photo) : asset('gambar/logo.png') }}" 
                         class="w-16 h-16 rounded-full mx-auto mb-3 border-2 border-neutral-600 group-hover:border-red-500 transition">
                    <h4 class="font-semibold text-white truncate">{{ $developer->name }}</h4>
                    <p class="text-neutral-400 text-sm truncate">{{ $developer->specialization ?? 'Developer' }}</p>
                    <div class="flex items-center justify-center gap-1 mt-2">
                        <svg class="w-4 h-4 fill-current text-yellow-500" viewBox="0 0 20 20">
                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.561-.955L10 0l2.95 5.955 6.561.955-4.756 4.635 1.123 6.545z"/>
                        </svg>
                        <span class="text-sm text-neutral-400">{{ number_format($developer->average_rating ?? 0, 1) }}</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Services Section -->
        <div>
            <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                <span class="text-2xl">🛍️</span> Layanan
            </h2>
            
            @if($services->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($services as $service)
                    @include('components.service-card', ['service' => $service])
                @endforeach
            </div>
            @else
            <div class="text-center py-16 bg-neutral-800 rounded-2xl border border-neutral-700">
                <div class="text-6xl mb-4">🔍</div>
                <h3 class="text-xl font-bold text-white mb-2">Tidak ada hasil</h3>
                <p class="text-neutral-400 mb-6">Coba kata kunci lain atau hapus filter kategori</p>
                <a href="{{ route('home') }}" 
                   class="inline-block px-6 py-3 bg-gradient-to-r from-red-700 to-red-800 text-white font-semibold rounded-xl hover:brightness-110 transition">
                    Kembali ke Beranda
                </a>
            </div>
            @endif
        </div>

    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
