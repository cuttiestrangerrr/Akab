@include('nav.navDev')

<main class="ml-60 pt-20 bg-neutral-900 text-white min-h-screen">
    <div class="max-w-4xl mx-auto px-6 py-12">
        
        <!-- Profile Header -->
        <div class="bg-neutral-900 rounded-2xl border border-neutral-800 p-8 mb-12" x-data="{ isEditing: false }">
            <div class="flex flex-col md:flex-row gap-8 items-start">
                
                <!-- Photo -->
                <div class="w-32 h-32 rounded-full border-4 border-neutral-800 overflow-hidden shrink-0 relative group">
                     <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('gambar/logo.png') }}" class="w-full h-full object-cover">
                     <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300 cursor-pointer" @click="isEditing = true">
                        <span class="text-xs font-bold">Edit</span>
                     </div>
                </div>

                <!-- Info Display -->
                <div class="flex-1 w-full" x-show="!isEditing">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-2">{{ $user->name }}</h1>
                            <p class="text-neutral-400 mb-4">{{ $user->email }}</p>
                        </div>
                        <button @click="isEditing = true" class="px-4 py-2 bg-neutral-800 hover:bg-neutral-700 text-sm font-medium rounded-lg transition border border-neutral-700">Edit Profil</button>
                    </div>
                    
                    <div class="mb-6">
                        <h3 class="text-sm font-bold text-neutral-500 uppercase tracking-widest mb-2">Bio</h3>
                        <p class="text-neutral-300 leading-relaxed">{{ $user->description ?? 'Belum ada bio.' }}</p>
                    </div>

                    <div class="flex gap-4">
                        @if($user->instagram_link)
                            <a href="{{ $user->instagram_link }}" target="_blank" class="text-neutral-400 hover:text-white transition"><i class="fab fa-instagram text-xl"></i> Instagram</a>
                        @endif
                        @if($user->github_link)
                            <a href="{{ $user->github_link }}" target="_blank" class="text-neutral-400 hover:text-white transition"><i class="fab fa-github text-xl"></i> GitHub</a>
                        @endif
                        @if($user->website_link)
                            <a href="{{ $user->website_link }}" target="_blank" class="text-neutral-400 hover:text-white transition"><i class="fas fa-globe text-xl"></i> Website</a>
                        @endif
                    </div>
                </div>

                <!-- Edit Form -->
                <div class="flex-1 w-full" x-show="isEditing" style="display: none;">
                    <form action="{{ route('developer.community.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf @method('PUT')
                        
                        <div>
                            <label class="block text-sm text-neutral-400 mb-1">Foto Profil</label>
                            <input type="file" name="profile_photo" class="block w-full text-sm text-neutral-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-600 file:text-white hover:file:bg-red-700"/>
                        </div>

                        <div>
                            <label class="block text-sm text-neutral-400 mb-1">Bio</label>
                            <textarea name="description" rows="3" class="w-full bg-neutral-800 border border-neutral-700 rounded-lg p-3 text-white focus:outline-none focus:border-red-600">{{ $user->description }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm text-neutral-400 mb-1">Instagram URL</label>
                                <input type="url" name="instagram_link" value="{{ $user->instagram_link }}" class="w-full bg-neutral-800 border border-neutral-700 rounded-lg p-2 text-white focus:outline-none focus:border-red-600">
                            </div>
                            <div>
                                <label class="block text-sm text-neutral-400 mb-1">GitHub URL</label>
                                <input type="url" name="github_link" value="{{ $user->github_link }}" class="w-full bg-neutral-800 border border-neutral-700 rounded-lg p-2 text-white focus:outline-none focus:border-red-600">
                            </div>
                            <div>
                                <label class="block text-sm text-neutral-400 mb-1">Website URL</label>
                                <input type="url" name="website_link" value="{{ $user->website_link }}" class="w-full bg-neutral-800 border border-neutral-700 rounded-lg p-2 text-white focus:outline-none focus:border-red-600">
                            </div>
                        </div>

                        <div class="flex gap-3 justify-end pt-4">
                            <button type="button" @click="isEditing = false" class="px-4 py-2 text-neutral-400 hover:text-white">Batal</button>
                            <button type="submit" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- My Posts Feed -->
        <h2 class="text-2xl font-bold mb-6 border-b border-neutral-800 pb-4">Postingan Saya</h2>
        <div class="space-y-6">
            @forelse($posts as $post)
            <div class="bg-neutral-900 p-6 rounded-xl border border-neutral-800">
                <!-- Header -->
                <div class="flex justify-between items-start mb-4">
                    <div class="flex gap-3">
                         <img src="{{ $post->developer->profile_photo ? asset('storage/' . $post->developer->profile_photo) : asset('gambar/logo.png') }}" class="w-10 h-10 rounded-full bg-neutral-700 object-cover">
                        <div>
                            <h4 class="font-bold text-white">{{ $post->developer->name }}</h4>
                            <p class="text-xs text-neutral-400">{{ $post->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.outside="open = false" class="text-neutral-400 hover:text-white p-1">•••</button>
                        <div x-show="open" class="absolute right-0 mt-2 w-32 bg-neutral-800 border border-neutral-700 rounded shadow-xl z-10" style="display: none;">
                            <a href="{{ route('developer.community.edit', $post->id_postingan) }}" class="block px-4 py-2 text-sm text-neutral-300 hover:bg-neutral-700 hover:text-white">Edit</a>
                            <form action="{{ route('developer.community.destroy', $post->id_postingan) }}" method="POST" onsubmit="return confirm('Hapus postingan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-neutral-700">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <p class="text-neutral-200 mb-4 leading-relaxed whitespace-pre-line">{{ $post->konten }}</p>

                <!-- Image Attachment -->
                @if($post->lampiran_url)
                <div class="mb-4 rounded-lg overflow-hidden border border-neutral-700">
                    <img src="{{ asset('storage/' . $post->lampiran_url) }}" class="w-full max-h-96 object-cover">
                </div>
                @endif

                <!-- Code Snippet -->
                @if($post->code)
                <div class="relative group my-4 rounded-lg overflow-hidden border border-neutral-700">
                    <div class="flex justify-between items-center bg-neutral-800 px-4 py-2 border-b border-neutral-700">
                        <span class="text-xs text-neutral-400 uppercase font-mono">{{ $post->language ?? 'text' }}</span>
                    </div>
                    <pre class="m-0 bg-[#1e1e1e] p-4 overflow-x-auto"><code class="language-{{ $post->language ?? 'plaintext' }} text-sm font-mono">{{ $post->code }}</code></pre>
                </div>
                @endif

                <!-- Stats -->
                <div class="flex items-center gap-6 text-sm text-neutral-400 pt-4 border-t border-neutral-800 mt-4">
                     <span class="flex items-center gap-2"><svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg> {{ $post->likes->count() }} Likes</span>
                     <span class="flex items-center gap-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg> {{ $post->comments->count() }} Comments</span>
                </div>
            </div>
            @empty
            <div class="text-center py-20 bg-neutral-900 rounded-xl border border-neutral-800">
                <p class="text-neutral-400">Anda belum membuat postingan.</p>
                <a href="{{ route('developer.community') }}" class="inline-block mt-4 text-red-500 hover:text-red-400 font-semibold">Buat Postingan Baru</a>
            </div>
            @endforelse
        </div>
    </div>
</main>
