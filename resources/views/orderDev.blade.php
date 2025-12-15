@include('nav.navDev')

<main class="ml-60 pt-20 bg-neutral-900 text-white min-h-screen">
    <div class="p-6">
        <h1 class="text-2xl font-semibold mb-6">Log Penawaran Jasa</h1>

        <div class="grid gap-6">
            @forelse($orders as $order)
            <div class="bg-neutral-800 p-6 rounded-xl border border-neutral-700 shadow-lg flex justify-between items-start hover:border-neutral-600 transition">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <span class="bg-yellow-600/20 text-yellow-500 px-3 py-1 rounded text-xs font-bold uppercase tracking-wide">
                            {{ $order->status }}
                        </span>
                        <span class="text-neutral-400 text-sm">
                            {{ $order->created_at->diffForHumans() }}
                        </span>
                    </div>

                    <h3 class="text-xl font-bold text-white mb-1">
                        {{ $order->nama_proyek }}
                    </h3>
                    
                    <div class="flex items-center gap-2 mt-3">
                        <img src="{{ $order->client->profile_photo ? asset('storage/' . $order->client->profile_photo) : asset('gambar/logo.png') }}" 
                             class="w-6 h-6 rounded-full">
                        <span class="text-neutral-300 text-sm">
                            Klien: <span class="font-semibold text-white">{{ $order->client->name }}</span>
                        </span>
                    </div>

                    <div class="mt-4 bg-neutral-900/50 p-3 rounded-lg border border-neutral-800">
                        <p class="text-sm text-neutral-400 italic">Catatan Klien:</p>
                        <p class="text-neutral-200 mt-1">{{ $order->deskripsi }}</p>
                    </div>
                </div>

                <div class="text-right flex flex-col items-end gap-3">
                    <div class="text-2xl font-bold text-green-400">
                        Rp {{ number_format($order->harga_estimasi, 0, ',', '.') }}
                    </div>
                    
                    <div class="flex gap-2">
                        <button class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 rounded-lg text-sm text-white font-medium transition">
                            Tolak
                        </button>
                        <button class="px-4 py-2 bg-green-600 hover:bg-green-700 rounded-lg text-sm text-white font-bold transition">
                            Terima Pesanan
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-20 bg-neutral-800 rounded-xl border border-neutral-700">
                <img src="{{ asset('gambar/cart.png') }}" class="w-16 mx-auto opacity-20 mb-4">
                <p class="text-neutral-400">Belum ada pesanan masuk.</p>
            </div>
            @endforelse
        </div>
    </div>
</main>