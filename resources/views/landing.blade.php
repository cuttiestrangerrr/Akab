@include('nav.navbar')

<main class="pt-30 bg-neutral-900 min-h-screen">
    
    <!-- Hero Carousel Section -->
    <div class="relative w-full overflow-hidden bg-gradient-to-r from-neutral-900 via-neutral-800 to-neutral-900" x-data="carousel()">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                <span class="bg-white bg-clip-text text-transparent">Layanan Unggulan</span>
            </h2>
            
            <!-- Carousel Container -->
            <div class="relative">
                <!-- Carousel Slides -->
                <div class="overflow-hidden rounded-2xl">
                    <div class="flex transition-transform duration-500 ease-out" 
                         :style="{ transform: `translateX(-${currentSlide * 100}%)` }">
                        @foreach($featured as $service)
                        <div class="w-full flex-shrink-0 px-2">
                            <a href="{{ route('service.show', $service->id_service) }}" 
                               class="block relative h-72 rounded-2xl overflow-hidden group">
                                <div class="absolute inset-0 bg-gradient-to-r from-red-700/80 to-red-800/80"></div>
                                @if($service->thumbnail)
                                    <img src="{{ asset('storage/' . $service->thumbnail) }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-8">
                                    <span class="inline-block bg-red-600 px-3 py-1 rounded-full text-xs font-semibold text-white mb-3">
                                        {{ $service->kategori }}
                                    </span>
                                    <h3 class="text-2xl font-bold text-white mb-2">{{ $service->judul }}</h3>
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $service->developer->profile_photo ? asset('storage/' . $service->developer->profile_photo) : asset('gambar/logo.png') }}" 
                                             class="w-8 h-8 rounded-full border-2 border-white">
                                        <span class="text-white/80">{{ $service->developer->name }}</span>
                                        <span class="text-red-400 font-bold ml-auto">Rp {{ number_format($service->harga_mulai, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Navigation Arrows -->
                <button @click="prev()" 
                        class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-black/50 hover:bg-red-600 rounded-full flex items-center justify-center text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button @click="next()" 
                        class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-black/50 hover:bg-red-600 rounded-full flex items-center justify-center text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
                
                <!-- Dots Indicator -->
                <div class="flex justify-center gap-2 mt-4">
                    @foreach($featured as $index => $service)
                    <button @click="goTo({{ $index }})" 
                            class="w-3 h-3 rounded-full transition"
                            :class="currentSlide === {{ $index }} ? 'bg-red-500' : 'bg-neutral-600 hover:bg-neutral-500'">
                    </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Category Tabs Section -->
    <div class="bg-neutral-900 py-6" x-data="{ activeCategory: 'Semua' }">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Category Tabs -->
            <div class="flex flex-wrap gap-3 mb-8 justify-center">
                <button @click="activeCategory = 'Semua'" 
                        class="px-5 py-2.5 rounded-full font-semibold transition-all duration-300"
                        :class="activeCategory === 'Semua' 
                            ? 'bg-gradient-to-r from-red-700 to-red-800 text-white shadow-lg shadow-red-700/30' 
                            : 'bg-neutral-800 text-neutral-400 hover:bg-neutral-700 hover:text-white border border-neutral-700'">
                    Semua
                </button>
                @foreach($categories as $category)
                <button @click="activeCategory = '{{ $category }}'" 
                        class="px-5 py-2.5 rounded-full font-semibold transition-all duration-300"
                        :class="activeCategory === '{{ $category }}' 
                            ? 'bg-gradient-to-r from-red-700 to-red-800 text-white shadow-lg shadow-red-700/30' 
                            : 'bg-neutral-800 text-neutral-400 hover:bg-neutral-700 hover:text-white border border-neutral-700'">
                    {{ $category }}
                </button>
                @endforeach
            </div>

            <!-- Rekomendasi Section -->
            <div class="mb-10" x-show="activeCategory === 'Semua'">
                <div class="bg-neutral-800 rounded-2xl p-6 border mb-8">
                    <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">Rekomendasi untuk Anda
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach($recommended->take(4) as $service)
                            @include('components.service-card', ['service' => $service])
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- All Services (Semua) with Load More -->
            <div x-show="activeCategory === 'Semua'" x-transition x-data="{ visibleCount: 20 }">
                <h3 class="text-xl font-bold text-white mb-4">Semua Layanan</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($allServices as $index => $service)
                        <div x-show="{{ $index }} < visibleCount" x-transition>
                            @include('components.service-card', ['service' => $service])
                        </div>
                    @endforeach
                </div>
                
                @if($allServices->count() > 20)
                <div class="text-center mt-8" x-show="visibleCount < {{ $allServices->count() }}">
                    <button @click="visibleCount += 10" 
                            class="px-8 py-3 bg-neutral-800 border border-neutral-600 text-white font-semibold rounded-xl hover:bg-neutral-700 hover:border-red-600 transition">
                        Tampilkan Lebih Banyak
                        <span class="text-neutral-400 ml-2">({{ $allServices->count() }} layanan)</span>
                    </button>
                </div>
                @endif
            </div>

            <!-- Services by Category -->
            @foreach($categories as $category)
            <div x-show="activeCategory === '{{ $category }}'" x-transition>
                <h3 class="text-xl font-bold text-white mb-4">{{ $category }}</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse($servicesByCategory[$category] as $service)
                        @include('components.service-card', ['service' => $service])
                    @empty
                        <div class="col-span-full text-center py-12">
                            <div class="text-6xl mb-4">🔍</div>
                            <p class="text-neutral-400">Belum ada layanan di kategori ini</p>
                        </div>
                    @endforelse
                </div>
            </div>
            @endforeach
        </div>
    </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script>
function carousel() {
    return {
        currentSlide: 0,
        totalSlides: {{ count($featured) }},
        autoPlayInterval: null,
        
        init() {
            this.startAutoPlay();
        },
        
        startAutoPlay() {
            this.autoPlayInterval = setInterval(() => {
                this.next();
            }, 5000);
        },
        
        stopAutoPlay() {
            clearInterval(this.autoPlayInterval);
        },
        
        next() {
            this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
        },
        
        prev() {
            this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
        },
        
        goTo(index) {
            this.currentSlide = index;
        }
    }
}
</script>
