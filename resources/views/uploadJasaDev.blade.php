@include('nav.navDev')

<main class="ml-60 pt-20 bg-neutral-900">
    <div class="p-6 text-white min-h-screen">

        <h1 class="text-2xl mb-6 font-semibold ">{{ isset($service) ? 'Edit Jasa' : 'Upload Jasa' }}</h1>

        <div 
            x-data="{
    nama: '{{ isset($service) ? $service->judul : old('nama', '') }}',
    deskripsi: `{{ isset($service) ? $service->deskripsi : old('deskripsi', '') }}`,
    kategori: '{{ isset($service) ? $service->kategori : old('kategori', '') }}',
    gambarPreview: '{{ isset($service) && $service->thumbnail ? asset('storage/' . $service->thumbnail) : null }}',
    addons: [],
    addonName: '',
    addonPrice: '',
    
    // Fungsi untuk membatasi 250 kata
    deskripsiPreview() {
        if (!this.deskripsi) return '';

        const words = this.deskripsi.split(/\s+/);
        if (words.length <= 250) return this.deskripsi;

        return words.slice(0, 80).join(' ') + '...';
    }
}"
            class="grid grid-cols-1 lg:grid-cols-2 gap-10"
        >

            <form action="{{ isset($service) ? route('developer.services.update', $service->id_service) : route('developer.services.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data"
                  class="space-y-5">
                  @if(isset($service))
                    @method('PUT')
                  @endif

                @csrf

                <div class="bg-neutral-800 p-6 rounded-xl shadow-lg border border-neutral-700 space-y-5">
                    <h3 class="text-2xl mb-6 font-semibold ">Upload Jasa</h3>
                    <div class="flex flex-col gap-2">
                        <label class="font-regular">Nama Jasa</label>
                        <input type="text" 
                               name="nama" 
                               x-model="nama"
                               class="px-4 py-2 rounded bg-neutral-700 text-white focus:ring focus:ring-blue-600"
                               placeholder="Masukkan nama jasa" required>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="font-regular">Deskripsi</label>
                        <textarea name="deskripsi"
                                  x-model="deskripsi"
                                  class="px-4 py-2 rounded bg-neutral-700 text-white focus:ring focus:ring-blue-600"
                                  rows="4"
                                  placeholder="Deskripsi jasa" required></textarea>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="font-regular">Kategori</label>
                        <select name="kategori" 
                                x-model="kategori"
                                class="px-4 py-2 rounded bg-neutral-700 text-white focus:ring focus:ring-blue-600">
                            <option value="">-- pilih kategori --</option>
                            <option>Desain</option>
                            <option>Editing Video</option>
                            <option>Pemrograman</option>
                            <option>Konsultasi</option>
                            <option>Layanan Lain</option>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="font-regular">Upload Gambar</label>
                        <input type="file" 
                               name="gambar"
                               accept="image/*"
                               @change="gambarPreview = URL.createObjectURL($event.target.files[0])"
                               class="px-4 py-2 rounded bg-neutral-700 text-white cursor-pointer focus:ring focus:ring-blue-600"
                               {{ isset($service) ? '' : 'required' }}>
                               
                        <!-- Temporary Price Input until Add-on logic is full -->
                         <div class="flex flex-col gap-2">
                            <label class="font-regular">Harga Mulai (Rp)</label>
                            <input type="number" 
                                   name="harga_mulai" 
                                   value="{{ old('harga_mulai', $service->harga_mulai ?? 0) }}"
                                   class="px-4 py-2 rounded bg-neutral-700 text-white focus:ring focus:ring-blue-600"
                                   required>
                        </div>
                    </div>

                </div>

<div class="bg-neutral-800 p-6 rounded-xl shadow-lg border border-neutral-700 space-y-4 max-h-[26vh] overflow-y-auto"
     x-data="{
         addons: {{ isset($service) && $service->addons ? json_encode($service->addons) : '[]' }},
addAddon() {
    this.addons.push({ name: '', price: 0 });
},
removeAddon(index) {
    this.addons.splice(index, 1);
},
            ],
         addonName: '',
         addonPrice: ''
     }">

    <h3 class="text-2xl mb-6 font-semibold ">Kalkulator Jasa</h3>
    <h5 class="text-2xl mb-6 font-regular ">Add-on Jasa</h5>

    <div class="flex gap-3">
        <input type="text"
               placeholder="Nama Add-on"
               x-model="addonName"
               class="w-full px-3 py-2 rounded bg-neutral-700 text-white focus:ring focus:ring-blue-600">

        <input type="number"
               placeholder="Harga"
               x-model="addonPrice"
               class="w-32 px-3 py-2 rounded bg-neutral-700 text-white focus:ring focus:ring-blue-600">

        <button type="button"
                @click="
                    if(addonName && addonPrice){
                        addons.push({name: addonName, price: addonPrice});
                        addonName=''; addonPrice='';
                    }
                "
                class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg font-semibold">
            +
        </button>
    </div>

    <template x-if="addons.length > 0">
        <ul class="space-y-2">
            <template x-for="(item, index) in addons" :key="index">
                <li class="flex justify-between items-center bg-neutral-700 px-3 py-2 rounded">
                    <span class="text-white" x-text="item.name + ' - Rp ' + Number(item.price).toLocaleString('id-ID')"></span>

                    <button @click="addons.splice(index,1)"
                            class="text-red-400 hover:text-red-500 font-bold">
                        Hapus
                    </button>
                </li>
            </template>
        </ul>
    </template>

    <template x-if="addons.length === 0">
        <p class="text-neutral-400 text-sm">Belum ada add-ons.</p>
    </template>

    <input type="hidden" name="addons" :value="JSON.stringify(addons)">
</div>

                <button type="submit" 
                        class="w-full bg-red-600 hover:bg-red-700 py-3 rounded-lg font-semibold transition">
                    Upload Jasa
                </button>

            </form>

            <div class="bg-neutral-800 p-6 rounded-xl shadow-lg border border-neutral-700
            max-h-[90vh] overflow-y-auto scrollbar-thin scrollbar-thumb-neutral-600 scrollbar-track-neutral-800">

                <h3 class="text-xl font-bold mb-6">Preview Jasa</h3>

                <div class="w-full h-64 bg-neutral-700 rounded-lg overflow-hidden flex items-center justify-center mb-5">
                    <template x-if="gambarPreview">
                        <img :src="gambarPreview" class="w-full h-full object-contain">
                    </template>

                    <template x-if="!gambarPreview">
                        <p class="text-neutral-400">Gambar akan tampil di sini</p>
                    </template>
                </div>

                <h3 class="text-2xl font-bold text-white leading-tight mb-5"
                    x-text="nama || 'Nama jasa akan tampil di sini'"></h3>

                <p class="mt-2 text-sm text-neutral-300 px-3 py-1 bg-neutral-700 inline-block rounded mb-5"
                   x-text="kategori || 'Kategori'"></p>

                <div class="mt-4 max-h-40 overflow-y-auto scrollbar-thin scrollbar-thumb-neutral-600 scrollbar-track-neutral-800 rounded p-2">
    <p class="text-neutral-300 leading-relaxed"
       x-text="deskripsiPreview() || 'Deskripsi jasa akan tampil di sini...'">
    </p>
</div>

<div class="bg-neutral-700 p-3 rounded-lg mt-9 max-h-[45vh] overflow-y-auto">
    <h4>
        Kalkulator Jasa
    </h4>
    <div class="mt-6 bg-neutral-800  p-4 rounded-lg border border-neutral-600 space-y-4"
     x-data="{ selectedAddons: {} }">

    <h5 class="text-lg font-semibold  text-white">Penawaran Fitur</h5>

    <template x-if="addons.length === 0">
        <p class="p-3 rounded flex flex-col gap-3">Tidak ada fitur ditambahkan.</p>
    </template>

    <template x-for="(addon, index) in addons" :key="'client-addon-' + index">
        <div class="bg-neutral-800 p-4 rounded-lg border border-neutral-700 space-y-3">

            <!-- Nama Add-on -->
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-neutral-200 font-semibold" x-text="addon.name"></p>
                    <p class="text-green-400 text-sm"
                       x-text="'Rp ' + addon.price.toLocaleString('id-ID')">
                    </p>
                </div>

                <button 
                    @click="
                        if (!selectedAddons[index]) {
                            selectedAddons[index] = { offer: null };
                        } else {
                            delete selectedAddons[index];
                        }
                    "
                    class="px-3 py-2 rounded-lg font-semibold transition"
                    :class="selectedAddons[index] 
                        ? 'bg-red-600 hover:bg-red-700 text-white' 
                        : 'bg-green-600 hover:bg-green-700 text-white'"
                >
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

<div class="mt-6 bg-neutral-800 p-4 rounded-lg border border-neutral-600 space-y-3" 
     x-data="{ addons: [], customAddon: { name:'', price:0 }, selectedAddons: {} }">

    <h5 class="text-lg font-semibold text-white">Permintaan Tambahan</h5>

    <div class="bg-neutral-800 p-3 rounded flex flex-col gap-3">
        <input type="text"
               class="px-3 py-2 bg-neutral-700 text-white rounded text-sm"
               placeholder="Deskripsikan fitur tambahan yang Anda inginkan"
               x-model="customAddon.name">

        <input type="number"
               class="px-3 py-2 bg-neutral-700 text-white rounded text-sm"
               placeholder="Pengajuan harga (Rp)"
               x-model.number="customAddon.price">
    </div>

    <div class="mt-4 p-3 bg-neutral-900 rounded text-white flex justify-between items-center">
        <span class="font-semibold">Total Harga:</span>
        <span class="font-bold" 
              x-text="(Object.values(selectedAddons).reduce((sum, a) => sum + (a.offer || 0), 0) + (customAddon.price || 0)).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })">
            Rp 0
        </span>
    </div>
</div>
</div>



                <button type="button" 
                        class="mt-6 bg-red-600 hover:bg-red-700 py-3 w-full rounded-xl font-semibold transition">
                    Ajukan Pesanan
                </button>

            </div>

        </div>
    </div>
</main>