<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gabung Komunitas Developer - AkabDev</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-neutral-900 text-white font-sans min-h-screen flex flex-col items-center justify-center p-4">

    <div class="w-full max-w-2xl bg-neutral-800 p-8 rounded-2xl shadow-2xl border border-neutral-700">
        <div class="text-center mb-8">
            <img src="{{ asset('gambar/logo.png') }}" class="h-16 mx-auto mb-4" alt="Akab Logo">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-red-700 to-red-800 bg-clip-text text-transparent">
                Gabung Komunitas Developer
            </h1>
            <p class="text-neutral-400 mt-2">
                Berbagi, belajar, dan berkembang bersama komunitas developer Akab
            </p>
        </div>

        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        @if(session('info'))
            <div class="bg-neutral-500/10 border border-neutral-500 text-neutral-300 px-4 py-3 rounded-lg mb-6">
                {{ session('info') }}
            </div>
        @endif

        <!-- Benefits Section -->
        <div class="bg-neutral-700/50 rounded-xl p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4 text-red-400">Manfaat Komunitas Developer</h2>
            <ul class="space-y-3 text-neutral-300">
                <li class="flex items-start">
                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Berbagi tips, trik, dan pengalaman dengan developer lain</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Posting karya, code snippets, dan portfolio Anda</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Berdiskusi dan kolaborasi dengan developer se-Indonesia</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Tingkatkan visibilitas dengan profil komunitas dan social links</span>
                </li>
            </ul>
        </div>

        <form action="{{ route('developer.become.community.action') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Bio -->
            <div>
                <label for="bio" class="block text-sm font-medium text-neutral-300 mb-2">
                    Bio Komunitas <span class="text-neutral-500">(Opsional)</span>
                </label>
                <textarea id="bio" name="bio" rows="3"
                          class="w-full px-4 py-3 rounded-lg bg-neutral-700 border border-neutral-600 text-white focus:ring-2 focus:ring-red-500 focus:border-transparent outline-none transition"
                          placeholder="Ceritakan sedikit tentang diri Anda untuk komunitas...">{{ old('bio') }}</textarea>
                @error('bio')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Social Links -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-neutral-200">Social Media Links <span class="text-neutral-500 text-sm">(Opsional)</span></h3>
                
                <div>
                    <label for="instagram_link" class="block text-sm font-medium text-neutral-300 mb-2">
                        <svg class="inline w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                        Instagram
                    </label>
                    <input type="url" id="instagram_link" name="instagram_link" 
                           class="w-full px-4 py-3 rounded-lg bg-neutral-700 border border-neutral-600 text-white focus:ring-2 focus:ring-red-500 focus:border-transparent outline-none transition"
                           placeholder="https://instagram.com/username"
                           value="{{ old('instagram_link') }}">
                    @error('instagram_link')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="github_link" class="block text-sm font-medium text-neutral-300 mb-2">
                        <svg class="inline w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                        </svg>
                        GitHub
                    </label>
                    <input type="url" id="github_link" name="github_link" 
                           class="w-full px-4 py-3 rounded-lg bg-neutral-700 border border-neutral-600 text-white focus:ring-2 focus:ring-red-500 focus:border-transparent outline-none transition"
                           placeholder="https://github.com/username"
                           value="{{ old('github_link') }}">
                    @error('github_link')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="website_link" class="block text-sm font-medium text-neutral-300 mb-2">
                        <svg class="inline w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm1 16.057v-3.057h2.994c-.059 1.143-.212 2.24-.456 3.279-.823-.12-1.674-.188-2.538-.222zm1.957 2.162c-.499 1.33-1.159 2.497-1.957 3.456v-3.62c.666.028 1.319.081 1.957.164zm-1.957-7.219v-3.015c.868-.034 1.721-.103 2.548-.224.238 1.027.389 2.111.446 3.239h-2.994zm0-5.014v-3.661c.806.969 1.471 2.15 1.971 3.496-.642.084-1.3.137-1.971.165zm2.703-3.267c1.237.496 2.354 1.228 3.29 2.146-.642.234-1.311.442-2.019.607-.344-.992-.775-1.91-1.271-2.753zm-7.241 13.56c-.244-1.039-.398-2.136-.456-3.279h2.994v3.057c-.865.034-1.714.102-2.538.222zm2.538 1.776v3.62c-.798-.959-1.458-2.126-1.957-3.456.638-.083 1.291-.136 1.957-.164zm-2.994-7.055c.057-1.128.207-2.212.446-3.239.827.121 1.68.19 2.548.224v3.015h-2.994zm1.024-5.179c.5-1.346 1.165-2.527 1.97-3.496v3.661c-.671-.028-1.329-.081-1.97-.165zm-2.005-.35c-.708-.165-1.377-.373-2.018-.607.937-.918 2.053-1.65 3.29-2.146-.496.844-.927 1.762-1.272 2.753zm-.549 1.918c-.264 1.151-.434 2.36-.492 3.611h-3.933c.165-1.658.739-3.197 1.617-4.518.88.361 1.816.67 2.808.907zm.009 9.262c-.988.236-1.92.542-2.797.9-.89-1.328-1.471-2.879-1.637-4.551h3.934c.058 1.265.231 2.488.5 3.651zm.553 1.917c.342.976.768 1.881 1.257 2.712-1.223-.49-2.326-1.211-3.256-2.115.636-.229 1.299-.435 1.999-.597zm9.924 0c.7.163 1.362.367 1.999.597-.931.903-2.034 1.625-3.257 2.116.489-.832.915-1.737 1.258-2.713zm.553-1.917c.27-1.163.442-2.386.501-3.651h3.934c-.167 1.672-.748 3.223-1.638 4.551-.877-.358-1.81-.664-2.797-.9zm.501-5.651c-.058-1.251-.229-2.46-.492-3.611.992-.237 1.929-.546 2.809-.907.877 1.321 1.451 2.86 1.616 4.518h-3.933z"/>
                        </svg>
                        Website/Portfolio
                    </label>
                    <input type="url" id="website_link" name="website_link" 
                           class="w-full px-4 py-3 rounded-lg bg-neutral-700 border border-neutral-600 text-white focus:ring-2 focus:ring-red-500 focus:border-transparent outline-none transition"
                           placeholder="https://yourwebsite.com"
                           value="{{ old('website_link') }}">
                    @error('website_link')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Community Guidelines Agreement -->
            <div class="bg-neutral-700/50 rounded-xl p-6">
                <div class="flex items-start">
                    <input type="checkbox" id="agree_guidelines" name="agree_guidelines" value="1" 
                           class="mt-1 w-5 h-5 text-red-600 bg-neutral-700 border-neutral-600 rounded focus:ring-red-500" 
                           required>
                    <label for="agree_guidelines" class="ml-3 text-sm text-neutral-300">
                        Saya setuju untuk mengikuti <span class="text-red-400 font-semibold">pedoman komunitas</span> dan berkomitmen untuk:
                        <ul class="mt-2 ml-4 space-y-1 text-xs text-neutral-400">
                            <li>• Berbagi konten yang bermanfaat dan berkualitas</li>
                            <li>• Menghormati sesama anggota komunitas</li>
                            <li>• Tidak melakukan spam atau promosi berlebihan</li>
                            <li>• Menjaga diskusi tetap profesional dan konstruktif</li>
                        </ul>
                    </label>
                </div>
                @error('agree_guidelines')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" 
                    class="w-full py-4 px-4 bg-gradient-to-r from-red-700 to-red-800 hover:from-red-500 hover:to-red-700 text-white font-bold text-lg rounded-lg shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                Gabung Komunitas Sekarang!
            </button>

            <div class="text-center">
                <a href="{{ route('developer.dashboard') }}" class="text-sm text-neutral-500 hover:text-white transition">
                    Kembali ke Dashboard
                </a>
            </div>
        </form>
    </div>

</body>
</html>
