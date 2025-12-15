<div class="group relative bg-black border border-neutral-700 rounded-2xl hover:border-red-600/50 transition duration-300 overflow-hidden">
    <a href="{{ route('service.show', $service->id_service) }}">
        <div class="aspect-square w-full bg-neutral-800 overflow-hidden relative">
            @if($service->thumbnail)
                <img src="{{ asset('storage/' . $service->thumbnail) }}" 
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500" />
            @else
                <div class="w-full h-full flex items-center justify-center text-neutral-600">
                    <img src="{{ asset('gambar/produk-beta.png') }}" class="w-full h-full object-cover opacity-50" />
                </div>
            @endif
            <div class="absolute top-3 right-3 bg-gradient-to-r from-red-700 to-red-800 text-white text-xs px-3 py-1 rounded-full font-semibold">
                {{ $service->kategori }}
            </div>
            @if($service->views_count > 0)
            <div class="absolute top-3 left-3 bg-black/70 text-white text-xs px-2 py-1 rounded-full backdrop-blur-sm flex items-center gap-1">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                </svg>
                {{ $service->views_count }}
            </div>
            @endif
        </div>

        <div class="p-5">
            <h4 class="font-bold text-white truncate text-lg group-hover:text-red-400 transition" title="{{ $service->judul }}">
                {{ $service->judul }}
            </h4>
            <div class="flex items-center gap-2 mt-2">
                <img src="{{ $service->developer->profile_photo ? asset('storage/' . $service->developer->profile_photo) : asset('gambar/logo.png') }}" 
                     class="w-6 h-6 rounded-full border border-neutral-600">
                <span class="text-sm text-neutral-400 truncate">{{ $service->developer->name }}</span>
            </div>
            <div class="flex items-center justify-between mt-3">
                <p class="text-lg font-bold bg-gradient-to-r from-red-700 to-red-800 bg-clip-text text-transparent">
                    Rp {{ number_format($service->harga_mulai, 0, ',', '.') }}
                </p>
                <div class="flex items-center gap-1">
                    <svg class="w-4 h-4 fill-current text-yellow-500" viewBox="0 0 20 20">
                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.561-.955L10 0l2.95 5.955 6.561.955-4.756 4.635 1.123 6.545z"/>
                    </svg>
                    <span class="text-sm text-neutral-400">{{ number_format($service->developer->average_rating ?? 0, 1) }}</span>
                </div>
            </div>
        </div>
    </a>
    
    <div x-data="{ showCalculator: false }" class="px-5 pb-5">
        @include('kalkulator', ['showCalculator' => 'showCalculator'])
    </div>
</div>
