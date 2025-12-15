@include('nav.navbar')

<main class="w-full pt-20 bg-neutral-900 min-h-screen text-white">
    <div class="container mx-auto px-4 py-8">
        
        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10">

            <!-- Image Section -->
            <div class="space-y-4">
                <div class="bg-neutral-800 rounded-2xl overflow-hidden shadow-2xl border border-neutral-700 h-[500px] flex items-center justify-center">
                    @if($service->thumbnail)
                        <img src="{{ asset('storage/' . $service->thumbnail) }}" class="w-full h-full object-cover">
                    @else
                        <img src="{{ asset('gambar/produk-beta.png') }}" class="w-full h-full object-cover opacity-60">
                    @endif
                </div>
            </div>

            <!-- Details Section -->
            <div class="space-y-6">
                <!-- Breadcrumb -->
                <div class="text-sm text-neutral-400">
                    <a href="{{ route('home') }}" class="hover:text-white">Beranda</a> 
                    <span class="mx-2">/</span>
                    <span class="text-red-500 font-medium">{{ $service->kategori }}</span>
                </div>

                <h1 class="text-4xl font-bold leading-tight">{{ $service->judul }}</h1>
                
                <div class="flex items-center gap-4 py-4 border-y border-neutral-800">
                    <img src="{{ $service->developer->profile_photo ? asset('storage/' . $service->developer->profile_photo) : asset('gambar/logo.png') }}" 
                         class="w-12 h-12 rounded-full border border-neutral-600">
                    <div>
                        <p class="font-semibold text-lg">{{ $service->developer->name }}</p>
                        <p class="text-neutral-400 text-sm">{{ $service->developer->specialization ?? 'Developer' }}</p>
                    </div>
                    <div class="ml-auto flex items-center gap-1 text-yellow-500 bg-neutral-800 px-3 py-1 rounded-lg">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.561-.955L10 0l2.95 5.955 6.561.955-4.756 4.635 1.123 6.545z"/></svg>
                        <span class="font-bold text-white">{{ number_format($service->developer->average_rating, 1) }}</span>
                    </div>
                </div>

                <div class="prose prose-invert max-w-none text-neutral-300">
                    <h3 class="text-white text-xl font-semibold mb-2">Deskripsi Layanan</h3>
                    <p class="whitespace-pre-line leading-relaxed">
                        {{ $service->deskripsi }}
                    </p>
                </div>

                <div class="bg-neutral-800 p-6 rounded-xl border border-neutral-700 shadow-lg mt-8"
                     x-data="{
                        basePrice: {{ $service->harga_mulai }},
                        addons: {{ $service->addons ? json_encode($service->addons) : '[]' }},
                        selectedAddons: [],
                        customAddonName: '',
                        customAddonPrice: '',
                        
                        get totalPrice() {
                            let total = this.basePrice;
                            
                            // Sum selected predefined addons
                            this.selectedAddons.forEach(index => {
                                if(this.addons[index]) {
                                    total += Number(this.addons[index].price);
                                }
                            });

                            // Add custom addon price (one-time logic for now to keep simple)
                            if(this.customAddonPrice) {
                                total += Number(this.customAddonPrice);
                            }

                            return total;
                        },

                        formatRupiah(number) {
                            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
                        }
                     }">
                    
                    <div class="flex justify-between items-end mb-4 border-b border-neutral-700 pb-4">
                        <span class="text-neutral-400">Total Estimasi</span>
                        <span class="text-3xl font-bold text-red-500" x-text="formatRupiah(totalPrice)">Rp 0</span>
                    </div>

                    <div class="space-y-4 mb-6">
                        <h4 class="font-semibold text-white">Tambahan Fitur (Add-ons)</h4>
                        
                        <template x-if="addons.length === 0">
                            <p class="text-sm text-neutral-500 italic">Tidak ada fitur tambahan tersedia.</p>
                        </template>

                        <div class="space-y-2">
                             <template x-for="(addon, index) in addons" :key="index">
                                <label class="flex items-center justify-between p-3 rounded bg-neutral-700/50 cursor-pointer border border-transparent hover:border-neutral-500 transition">
                                    <div class="flex items-center gap-3">
                                        <input type="checkbox" :value="index" x-model="selectedAddons" class="w-5 h-5 rounded text-red-600 focus:ring-red-500 bg-neutral-800 border-neutral-600">
                                        <span class="text-white" x-text="addon.name"></span>
                                    </div>
                                    <span class="font-bold text-green-400" x-text="'+ ' + formatRupiah(addon.price)"></span>
                                </label>
                             </template>
                        </div>

                        <!-- Custom Request Section -->
                        <div class="pt-4 border-t border-neutral-700">
                            <h5 class="text-sm font-semibold text-white mb-2">Permintaan Khusus (Optional)</h5>
                            <div class="grid grid-cols-3 gap-2">
                                <input type="text" x-model="customAddonName" placeholder="Nama fitur..." class="col-span-2 px-3 py-2 bg-neutral-700 rounded text-sm text-white focus:outline-none focus:ring-1 focus:ring-red-500">
                                <input type="number" x-model="customAddonPrice" placeholder="Harga (Rp)" class="px-3 py-2 bg-neutral-700 rounded text-sm text-white focus:outline-none focus:ring-1 focus:ring-red-500">
                            </div>
                        </div>
                    </div>

                    @auth
                        @if(Auth::id() !== $service->id_developer)
                        <form action="{{ route('service.order', $service->id_service) }}" method="POST" class="space-y-4">
                            @csrf
                            
                            <!-- Hidden inputs to send calculator data -->
                            <input type="hidden" name="selected_addons" :value="JSON.stringify(selectedAddons.map(i => addons[i]))">
                            <input type="hidden" name="custom_addon_name" :value="customAddonName">
                            <input type="hidden" name="custom_addon_price" :value="customAddonPrice">

                            <div>
                                <label class="block text-sm text-neutral-400 mb-1">Catatan Tambahan (Opsional)</label>
                                <textarea name="notes" rows="2" 
                                          class="w-full bg-neutral-700 rounded-lg p-3 text-white focus:ring-2 focus:ring-red-500 focus:outline-none"
                                          placeholder="Jelaskan kebutuhan spesifik Anda..."></textarea>
                            </div>
                            <button type="submit" 
                                    class="w-full py-4 bg-gradient-to-r from-red-700 to-red-800 hover:from-red-500 hover:to-red-600 text-white font-bold rounded-lg shadow-lg transform transition hover:scale-[1.01]">
                                Pesan Jasa Ini Sekarang
                            </button>
                        </form>
                        @else
                            <div class="w-full py-3 bg-neutral-700 text-center rounded-lg text-neutral-400 font-medium cursor-not-allowed">
                                Ini adalah jasa Anda sendiri
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="block w-full py-4 bg-neutral-700 hover:bg-neutral-600 text-center text-white font-bold rounded-lg transition">
                            Login untuk Memesan
                        </a>
                    @endauth

                    <p class="text-center text-xs text-neutral-500 mt-3">
                        Transaksi aman dengan AkabDev Guarantee. Uang ditahan hingga pekerjaan selesai.
                    </p>
                </div>

            </div>
        </div>

    </div>
</main>
