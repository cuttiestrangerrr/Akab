@include('nav.navDev')

<main class="ml-60 pt-20 bg-neutral-900 text-white min-h-screen">
    <div class="p-8 max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-2">Komunitas Developer</h1>
        <p class="text-neutral-400 mb-8">Sharing code, diskusi, dan kolaborasi dengan sesama developer AkabDev.</p>

        <!-- Create Post Form -->
        <div class="bg-neutral-800 p-6 rounded-xl border border-neutral-700 mb-8" x-data="{ showCode: false, showImage: false }">
            <form action="{{ route('developer.community.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex gap-4">
                    <img src="{{ optional(Auth::user())->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('gambar/logo.png') }}" 
                         class="w-10 h-10 rounded-full bg-neutral-700">
                    <div class="flex-1 space-y-3">
                        <textarea name="content" 
                                  class="w-full bg-neutral-900 border border-neutral-700 rounded-lg p-3 text-white focus:outline-none focus:border-red-600" 
                                  rows="3" 
                                  placeholder="Apa yang sedang Anda kerjakan? Bagikan kode..."></textarea>
                        
                        <!-- Extra Fields -->
                        <div x-show="showCode" x-transition class="space-y-2 bg-neutral-900 p-3 rounded">
                            <select name="language" class="w-full bg-neutral-800 border border-neutral-700 rounded p-2 text-sm text-white focus:outline-none focus:border-red-600">
                                <option value="" disabled selected>Pilih Bahasa</option>
                                <option value="php">PHP</option>
                                <option value="javascript">JavaScript</option>
                                <option value="html">HTML</option>
                                <option value="css">CSS</option>
                                <option value="python">Python</option>
                                <option value="java">Java</option>
                                <option value="sql">SQL</option>
                                <option value="bash">Bash</option>
                            </select>
                            <textarea name="code" rows="5" placeholder="Paste snippet kode di sini..." class="w-full bg-neutral-800 border border-neutral-700 rounded p-2 text-sm font-mono text-white"></textarea>
                        </div>

                        <div x-show="showImage" x-transition>
                            <input type="file" name="image" class="block w-full text-sm text-neutral-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-600 file:text-white hover:file:bg-red-700"/>
                        </div>

                        <div class="flex justify-between items-center pt-2 border-t border-neutral-700">
                            <div class="flex gap-2">
                                 <button type="button" @click="showCode = !showCode" :class="showCode ? 'text-red-500 bg-red-500/10' : 'text-neutral-400 hover:bg-neutral-700'" class="p-2 rounded text-sm flex items-center gap-1 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                                    Code
                                 </button>
                                 <button type="button" @click="showImage = !showImage" :class="showImage ? 'text-red-500 bg-red-500/10' : 'text-neutral-400 hover:bg-neutral-700'" class="p-2 rounded text-sm flex items-center gap-1 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Image
                                 </button>
                            </div>
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-semibold">Post</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Feed -->
        <div class="space-y-6">
            @forelse($posts as $post)
            <div class="bg-neutral-800 p-6 rounded-xl border border-neutral-700" x-data="{ showComments: false }">
                <!-- Header -->
                <div class="flex justify-between items-start mb-4">
                    <div class="flex gap-3">
                        <img src="{{ $post->developer->profile_photo ? asset('storage/' . $post->developer->profile_photo) : asset('gambar/logo.png') }}" class="w-10 h-10 rounded-full bg-neutral-700 object-cover">
                        <div>
                            <h4 class="font-bold text-white">{{ $post->developer->name }}</h4>
                            <p class="text-xs text-neutral-400">{{ $post->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    
                    @if(Auth::id() === $post->id_developer)
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.outside="open = false" class="text-neutral-400 hover:text-white p-1">•••</button>
                        <div x-show="open" class="absolute right-0 mt-2 w-32 bg-neutral-900 border border-neutral-700 rounded shadow-xl z-10" style="display: none;">
                            <a href="{{ route('developer.community.edit', $post->id_postingan) }}" class="block px-4 py-2 text-sm text-neutral-300 hover:bg-neutral-800 hover:text-white">Edit</a>
                            <form action="{{ route('developer.community.destroy', $post->id_postingan) }}" method="POST" onsubmit="return confirm('Hapus postingan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-neutral-800">Hapus</button>
                            </form>
                        </div>
                    </div>
                    @endif
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
                    <div class="flex justify-between items-center bg-neutral-900 px-4 py-2 border-b border-neutral-700">
                        <span class="text-xs text-neutral-400 uppercase font-mono">{{ $post->language ?? 'text' }}</span>
                        <button onclick="copyCode(this)" class="text-xs text-neutral-400 hover:text-white flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                            Copy
                        </button>
                    </div>
                    <pre class="m-0 bg-[#1e1e1e] p-4 overflow-x-auto"><code class="language-{{ $post->language ?? 'plaintext' }} text-sm font-mono">{{ $post->code }}</code></pre>
                </div>
                @endif

                <!-- Actions -->
                <div class="flex items-center gap-6 text-sm text-neutral-400 pt-4 border-t border-neutral-700 mt-4">
                    <form action="{{ route('developer.community.like', $post->id_postingan) }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 transition {{ $post->isLikedBy(Auth::user()) ? 'text-red-500' : 'hover:text-red-500' }}">
                            <svg class="w-5 h-5" fill="{{ $post->isLikedBy(Auth::user()) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            {{ $post->likes->count() }} Likes
                        </button>
                    </form>
                    
                    <button @click="showComments = !showComments" class="flex items-center gap-2 hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        {{ $post->comments->count() }} Comments
                    </button>
                </div>

                <!-- Comments Section -->
                <div x-show="showComments" style="display: none;" class="mt-4 pt-4 border-t border-neutral-700">
                    <div class="space-y-4 mb-4">
                        @foreach($post->comments as $comment)
                        <div class="space-y-3" x-data="{ isEditing: false, openDropdown: false, showReply: false }">
                            <div class="flex gap-3">
                                <img src="{{ $comment->user->profile_photo ? asset('storage/' . $comment->user->profile_photo) : asset('gambar/logo.png') }}" class="w-8 h-8 rounded-full bg-neutral-700 object-cover">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-baseline gap-2">
                                            <span class="text-sm font-bold text-white">{{ $comment->user->name }}</span>
                                            <span class="text-xs text-neutral-500">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        
                                        @if(Auth::id() === $comment->user_id)
                                        <div class="relative">
                                            <button @click="openDropdown = !openDropdown" @click.outside="openDropdown = false" class="text-neutral-500 hover:text-white p-1 rounded hover:bg-neutral-700">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                                            </button>
                                            <div x-show="openDropdown" class="absolute right-0 mt-2 w-32 bg-neutral-900 border border-neutral-700 rounded shadow-xl z-20" style="display: none;">
                                                <button @click="isEditing = true; openDropdown = false" class="block w-full text-left px-4 py-2 text-sm text-neutral-300 hover:bg-neutral-800 hover:text-white">Edit</button>
                                                <form action="{{ route('developer.community.comment.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Hapus komentar?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-neutral-800">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                        @endif
                                    </div>

                                    <template x-if="!isEditing">
                                        <div>
                                            <p class="text-sm text-neutral-300 whitespace-pre-wrap">{{ $comment->content }}</p>
                                            <button @click="showReply = !showReply" class="text-xs text-neutral-500 hover:text-white mt-1">Balas</button>
                                        </div>
                                    </template>
                                    
                                    <template x-if="isEditing">
                                        <form action="{{ route('developer.community.comment.update', $comment->id) }}" method="POST" class="mt-2">
                                            @csrf @method('PUT')
                                            <textarea name="content" class="w-full bg-neutral-800 border border-neutral-700 rounded px-3 py-2 text-sm text-white focus:outline-none focus:border-red-600 mb-2 min-h-[60px]">{{ $comment->content }}</textarea>
                                            <div class="flex gap-2">
                                                <button type="submit" class="text-xs bg-red-600 text-white px-3 py-1 rounded font-bold">Simpan</button>
                                                <button type="button" @click="isEditing = false" class="text-xs text-neutral-400 hover:text-white px-3 py-1">Batal</button>
                                            </div>
                                        </form>
                                    </template>

                                    <!-- Reply Form -->
                                    <div x-show="showReply" style="display: none;" class="mt-2">
                                        <form action="{{ route('developer.community.comment', $post->id_postingan) }}" method="POST" class="flex gap-2">
                                            @csrf
                                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                            <input type="text" name="content" placeholder="Tulis balasan..." class="flex-1 bg-neutral-800 border border-neutral-700 rounded px-3 py-1 text-xs text-white focus:outline-none focus:border-red-600">
                                            <button type="submit" class="text-red-500 hover:text-red-400 font-semibold text-xs">Kirim</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Replies -->
                            @if($comment->replies->count() > 0)
                            <div class="ml-10 space-y-3 border-l-2 border-neutral-700 pl-4">
                                @foreach($comment->replies as $reply)
                                <div class="flex gap-3" x-data="{ isEditingReply: false, openDropdownReply: false }">
                                    <img src="{{ $reply->user->profile_photo ? asset('storage/' . $reply->user->profile_photo) : asset('gambar/logo.png') }}" class="w-6 h-6 rounded-full bg-neutral-700 object-cover">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-baseline gap-2">
                                                <span class="text-xs font-bold text-white">{{ $reply->user->name }}</span>
                                                <span class="text-[10px] text-neutral-500">{{ $reply->created_at->diffForHumans() }}</span>
                                            </div>
                                            
                                            @if(Auth::id() === $reply->user_id)
                                            <div class="relative">
                                                <button @click="openDropdownReply = !openDropdownReply" @click.outside="openDropdownReply = false" class="text-neutral-500 hover:text-white p-1 rounded hover:bg-neutral-700">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                                                </button>
                                                <div x-show="openDropdownReply" class="absolute right-0 mt-2 w-32 bg-neutral-900 border border-neutral-700 rounded shadow-xl z-20" style="display: none;">
                                                    <button @click="isEditingReply = true; openDropdownReply = false" class="block w-full text-left px-4 py-2 text-xs text-neutral-300 hover:bg-neutral-800 hover:text-white">Edit</button>
                                                    <form action="{{ route('developer.community.comment.destroy', $reply->id) }}" method="POST" onsubmit="return confirm('Hapus balasan?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="block w-full text-left px-4 py-2 text-xs text-red-500 hover:bg-neutral-800">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                            @endif
                                        </div>

                                        <template x-if="!isEditingReply">
                                            <p class="text-xs text-neutral-300 whitespace-pre-wrap">{{ $reply->content }}</p>
                                        </template>
                                        
                                        <template x-if="isEditingReply">
                                            <form action="{{ route('developer.community.comment.update', $reply->id) }}" method="POST" class="mt-2">
                                                @csrf @method('PUT')
                                                <textarea name="content" class="w-full bg-neutral-800 border border-neutral-700 rounded px-3 py-2 text-xs text-white focus:outline-none focus:border-red-600 mb-2 min-h-[40px]">{{ $reply->content }}</textarea>
                                                <div class="flex gap-2">
                                                    <button type="submit" class="text-[10px] bg-red-600 text-white px-3 py-1 rounded font-bold">Simpan</button>
                                                    <button type="button" @click="isEditingReply = false" class="text-[10px] text-neutral-400 hover:text-white px-3 py-1">Batal</button>
                                                </div>
                                            </form>
                                        </template>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    
                    <form action="{{ route('developer.community.comment', $post->id_postingan) }}" method="POST" class="flex gap-2">
                        @csrf
                        <input type="text" name="content" placeholder="Tulis komentar..." class="flex-1 bg-neutral-900 border border-neutral-700 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:border-red-600">
                        <button type="submit" class="text-red-500 hover:text-red-400 font-semibold text-sm">Kirim</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="text-center py-20 bg-neutral-800 rounded-xl border border-neutral-700">
                <p class="text-neutral-400">Belum ada postingan. Jadilah yang pertama!</p>
            </div>
            @endforelse
        </div>
    </div>
</main>

<!-- Highlight.js for Syntax Highlighting -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<script>hljs.highlightAll();</script>

<script>
    function copyCode(btn) {
        const codeBlock = btn.closest('.group').querySelector('code');
        const text = codeBlock.innerText;
        
        navigator.clipboard.writeText(text).then(() => {
            const originalText = btn.innerHTML;
            btn.innerHTML = `<span class="text-green-400 font-bold">Copied!</span>`;
            setTimeout(() => {
                btn.innerHTML = originalText;
            }, 2000);
        }).catch(err => {
            console.error('Failed to copy: ', err);
        });
    }
</script>
