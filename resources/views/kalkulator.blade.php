<div x-data="{ showCalculator: false, addons: [], customAddon: { name:'', price:'' }, selectedAddons: {} }">

    <button @click="showCalculator = true"
        class="px-2 py-1 bg-gradient-to-r from-red-700 to-red-800 hover:brightness-110 
               text-white rounded-lg font-medium transition text-xs flex items-center justify-center gap-1">
        <img src="{{ asset('gambar/kalkulator.png') }}" alt="" width="24">
        Kalkulator Harga
    </button>

    <div x-show="showCalculator" x-transition.opacity class="fixed inset-0 flex items-center justify-center z-50">

        <div class="absolute inset-0 bg-black/50" @click="showCalculator = false"></div>

        <div class="bg-neutral-700 p-3 rounded-lg max-h-[80vh] w-full max-w-3xl overflow-y-auto relative z-10">

            <button @click="showCalculator = false" class="absolute top-3 right-3 text-white font-bold text-lg">✕</button>

            <h4 class="text-lg font-bold text-white mb-4">Kalkulator Jasa</h4>

            <div class="mt-2 bg-neutral-800 p-4 rounded-lg border border-neutral-600 space-y-4">
                <h5 class="text-lg font-semibold text-white">Penawaran Fitur</h5>

                <template x-if="addons.length === 0">
                    <p class="p-3 rounded flex flex-col gap-3 text-neutral-400">
                        Tidak fitur ditawarkan.
                    </p>
                </template>

                <template x-for="(addon, index) in addons" :key="'client-addon-' + index">
                    <div class="bg-neutral-800 p-4 rounded-lg border border-neutral-700 space-y-3">

                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-neutral-200 font-semibold" x-text="addon.name"></p>
                                <p class="text-green-400 text-sm" x-text="'Rp ' + addon.price.toLocaleString('id-ID')"></p>
                            </div>

                            <button 
                                @click="
                                    if (!selectedAddons[index]) { selectedAddons[index] = { offer: null }; } 
                                    else { delete selectedAddons[index]; }"
                                class="px-3 py-2 rounded-lg font-semibold transition"
                                :class="selectedAddons[index] 
                                    ? 'bg-red-600 hover:bg-red-700 text-white' 
                                    : 'bg-green-600 hover:bg-green-700 text-white'">
                                <span x-text="selectedAddons[index] ? '- Batal' : '+ Tambah'"></span>
                            </button>
                        </div>

                        <div x-show="selectedAddons[index]" x-transition class="space-y-2">
                            <label class="text-sm text-neutral-400">Penawaran Anda (Rp)</label>
                            <input type="number"
                                   x-model="selectedAddons[index].offer"
                                   placeholder="Masukkan penawaran..."
                                   class="w-full px-3 py-2 rounded bg-neutral-700 text-white border border-neutral-500 focus:ring focus:ring-blue-600">
                            <p class="text-xs text-neutral-400">
                                *Penawaran akan dikirim ke developer untuk dinegosiasi.
                            </p>
                        </div>
                    </div>
                </template>
            </div>

<div class="mt-6 bg-neutral-800 p-4 rounded-lg border border-neutral-600 space-y-3">
    <h5 class="text-lg font-semibold text-white">Permintaan Tambahan</h5>

    <div class="bg-neutral-800 p-3 rounded flex flex-col gap-3">
        <input type="text"
               class="px-3 py-2 bg-neutral-700 text-white rounded text-sm"
               placeholder="Deskripsikan fitur tambahan"
               x-model="customAddon.name">

        <input type="number"
               class="px-3 py-2 bg-neutral-700 text-white rounded text-sm"
               placeholder="Pengajuan harga (Rp)"
               x-model.number="customAddon.price">
    </div>

    <div class="mt-4 p-3 bg-neutral-900 rounded text-white flex justify-between items-center">
        <span class="font-semibold">Total Harga:</span>
        <span class="font-bold" x-text="(Object.values(selectedAddons).reduce((sum, a) => sum + (a.offer ? a.offer : 0), 0) + (customAddon.price ? customAddon.price : 0)).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })">
            Rp 0
        </span>
    </div>
</div>

            <button class="mt-4 w-full py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold">
                Ajukan Penawaran
            </button>
        </div>
    </div>
</div>