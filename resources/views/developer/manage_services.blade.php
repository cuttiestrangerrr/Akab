@include('nav.navDev')

<main class="ml-60 pt-20 bg-neutral-900 text-white min-h-screen">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Kelola Jasa Saya</h1>
            <a href="{{ route('developer.services.create') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-bold">
                + Tambah Jasa
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-600 text-white p-4 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-neutral-800 rounded-xl border border-neutral-700 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-neutral-700 text-neutral-300">
                    <tr>
                        <th class="px-6 py-3">Produk Jasa</th>
                        <th class="px-6 py-3">Kategori</th>
                        <th class="px-6 py-3">Harga Mulai</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-700">
                    @forelse($services as $service)
                    <tr class="hover:bg-neutral-700/50 transition">
                        <td class="px-6 py-4 flex items-center gap-4">
                            <img src="{{ asset('storage/' . $service->thumbnail) }}" class="w-12 h-12 rounded object-cover bg-neutral-600">
                            <div>
                                <p class="font-semibold">{{ $service->judul }}</p>
                                <p class="text-sm text-neutral-400 truncate w-64">{{ Str::limit($service->deskripsi, 50) }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-neutral-700 px-2 py-1 rounded text-sm">{{ $service->kategori }}</span>
                        </td>
                        <td class="px-6 py-4">
                            Rp {{ number_format($service->harga_mulai, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('developer.services.edit', $service->id_service) }}" class="text-red-400 hover:text-red-300 font-medium">Edit</a>
                            
                            <form action="{{ route('developer.services.destroy', $service->id_service) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus jasa ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-400 font-medium">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-neutral-400">
                            Anda belum memiliki produk jasa. Silakan upload jasa baru.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
