@include('nav.navDev')

<main class="ml-60 pt-20 bg-neutral-900 text-white min-h-screen">
    <div class="p-8 max-w-4xl mx-auto">
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('developer.community') }}" class="text-neutral-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h1 class="text-3xl font-bold">Edit Postingan</h1>
        </div>

        <div class="bg-neutral-800 p-6 rounded-xl border border-neutral-700" 
             x-data="{ showCode: {{ $post->code ? 'true' : 'false' }} }">
            
            <form action="{{ route('developer.community.update', $post->id_postingan) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-4">
                    <textarea name="content" 
                              class="w-full bg-neutral-900 border border-neutral-700 rounded-lg p-3 text-white focus:outline-none focus:border-red-600" 
                              rows="5" 
                              required>{{ old('content', $post->konten) }}</textarea>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="hasCode" x-model="showCode" class="w-4 h-4 rounded text-red-600 focus:ring-red-500 bg-neutral-900 border-neutral-700">
                        <label for="hasCode" class="text-sm text-neutral-300">Sertakan Kode</label>
                    </div>

                    <div x-show="showCode" x-transition class="space-y-2 bg-neutral-900 p-4 rounded-lg border border-neutral-700">
                        <label class="text-sm text-neutral-400">Bahasa</label>
                        <select name="language" class="w-full bg-neutral-800 border border-neutral-700 rounded p-2 text-sm text-white focus:border-red-600 focus:outline-none">
                            <option value="php" {{ old('language', $post->language) == 'php' ? 'selected' : '' }}>PHP</option>
                            <option value="javascript" {{ old('language', $post->language) == 'javascript' ? 'selected' : '' }}>JavaScript</option>
                            <option value="html" {{ old('language', $post->language) == 'html' ? 'selected' : '' }}>HTML</option>
                            <option value="css" {{ old('language', $post->language) == 'css' ? 'selected' : '' }}>CSS</option>
                            <option value="python" {{ old('language', $post->language) == 'python' ? 'selected' : '' }}>Python</option>
                            <option value="java" {{ old('language', $post->language) == 'java' ? 'selected' : '' }}>Java</option>
                            <option value="sql" {{ old('language', $post->language) == 'sql' ? 'selected' : '' }}>SQL</option>
                            <option value="bash" {{ old('language', $post->language) == 'bash' ? 'selected' : '' }}>Bash</option>
                        </select>
                        
                        <label class="text-sm text-neutral-400 mt-2 block">Snippet Kode</label>
                        <textarea name="code" rows="8" 
                                  placeholder="Paste kode di sini..." 
                                  class="w-full bg-neutral-800 border border-neutral-700 rounded p-2 text-sm font-mono text-white focus:border-red-600 focus:outline-none">{{ old('code', $post->code) }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('developer.community') }}" class="px-6 py-2 rounded-lg hover:bg-neutral-700 text-white transition">Batal</a>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-bold transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
