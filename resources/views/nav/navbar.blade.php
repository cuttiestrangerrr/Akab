<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AkabDev</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans min-h-screen flex flex-col">

    <nav class="nav shadow-md fixed top-0 z-50 w-full bg-black border-b border-neutral-800">
         <div class="container mx-auto px-4 pt-6 pb-1 flex justify-between items-center text-sm">

        @auth
            @if(Auth::user()->role === 'developer')
                <a href="{{ route('developer.dashboard') }}"
                   class="px-4 py-1 bg-gradient-to-r from-red-700 to-red-800 hover:brightness-110 
                          text-white rounded-lg font-medium transition text-xs">
                    Dashboard Developer
                </a>
            @else
                <a href="{{ route('developer.register') }}"
                   class="px-4 py-1 bg-gradient-to-r from-red-700 to-red-800 hover:brightness-110 
                          text-white rounded-lg font-medium transition text-xs">
                    Jadi Developer
                </a>
            @endif
        @else
            <a href="{{ route('login') }}"
               class="px-4 py-1 bg-gradient-to-r from-red-700 to-red-800 hover:brightness-110 
                      text-white rounded-lg font-medium transition text-xs">
                Jadi Developer
            </a>
        @endauth

        <div class="flex items-center gap-5">

            <a href="{{ url('/Contact us') }}"
               class="text-white hover:text-red-500 transition text-xs">
                Contact Us
            </a>

            <div class="flex items-center gap-2">

    @auth
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" 
                    @click.outside="open = false"
                    class="flex items-center gap-2 text-white hover:text-red-400 focus:outline-none">
                <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('gambar/logo.png') }}" 
                     class="w-8 h-8 rounded-full border border-neutral-600">
                <span class="font-medium">{{ Auth::user()->name }}</span>
                <svg class="w-4 h-4 ml-1 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl overflow-hidden text-gray-800 z-50">
                <a href="{{ url('/profile') }}" class="block px-4 py-2 hover:bg-red-600 hover:text-white transition-colors">Profile</a>
                @if(Auth::user()->role === 'developer')
                    <a href="{{ route('developer.dashboard') }}" class="block px-4 py-2 hover:bg-red-600 hover:text-white transition-colors">Developer Center</a>
                @endif
                <a href="{{ route('logout') }}" class="block px-4 py-2 hover:bg-red-600 hover:text-white text-red-500 transition-colors">Logout</a>
            </div>
        </div>
    @else
        <div class="flex items-center gap-2">
            <a href="{{ url('/login') }}"
            class="px-4 py-1 bg-gradient-to-r from-red-700 to-red-800 hover:brightness-110 
                    text-white rounded-lg font-medium transition text-xs">
                Login
            </a>

            <a href="{{ url('/register') }}"
            class="px-4 py-1 bg-gradient-to-r from-red-700 to-red-800 hover:brightness-110 
                    text-white rounded-lg font-medium transition text-xs">
                Register
            </a>
        </div>
    @endauth

</div>

        </div>

    </div>
    <div class="container mx-auto px-4 py-3 flex justify-between items-center gap-3">

        <a href="{{ url('/') }}" class="flex items-center">
            <img src="{{ asset('gambar/logo.png') }}" width="77" class="object-contain">
        </a>

        <div class="hidden md:flex flex-1 mx-6" x-data="searchAutocomplete()">
            <form action="{{ url('/search') }}" method="GET" class="w-full relative">
                <div class="flex bg-neutral-800 border border-neutral-700 rounded-3xl overflow-hidden"
                     :class="{ 'border-red-500': showSuggestions && suggestions.length > 0 }">
                    <input type="text"
                           name="q"
                           x-model="query"
                           @input.debounce.300ms="fetchSuggestions()"
                           @focus="showSuggestions = true"
                           @click.outside="showSuggestions = false"
                           @keydown.arrow-down.prevent="navigateDown()"
                           @keydown.arrow-up.prevent="navigateUp()"
                           @keydown.enter="selectCurrent($event)"
                           @keydown.escape="showSuggestions = false"
                           placeholder="Cari layanan, developer..."
                           autocomplete="off"
                           class="w-full px-4 py-2 bg-neutral-800 text-white focus:outline-none"
                    >
                    <button class="px-4 text-white font-semibold">
                        <img src="{{ asset('gambar/cari.png') }}" alt="" width="24">
                    </button>
                </div>
                
                <!-- Suggestions Dropdown -->
                <div x-show="showSuggestions && suggestions.length > 0"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="absolute top-full left-0 right-0 mt-2 bg-neutral-800 border border-neutral-700 rounded-2xl shadow-xl overflow-hidden z-50">
                    <template x-for="(item, index) in suggestions" :key="index">
                        <a :href="item.url"
                           @mouseenter="selectedIndex = index"
                           class="flex items-center gap-3 px-4 py-3 hover:bg-neutral-700 transition cursor-pointer"
                           :class="{ 'bg-neutral-700': selectedIndex === index }">
                            <!-- Icon by type -->
                            <div class="w-8 h-8 rounded-full flex items-center justify-center"
                                 :class="{
                                    'bg-red-600/20 text-red-400': item.type === 'service',
                                    'bg-neutral-600/20 text-neutral-400': item.type === 'category',
                                    'bg-red-600/20 text-red-400': item.type === 'developer'
                                 }">
                                <span x-show="item.type === 'service'">🛍️</span>
                                <span x-show="item.type === 'category'">📁</span>
                                <span x-show="item.type === 'developer'">👨‍💻</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-white font-medium truncate" x-text="item.label"></p>
                                <p class="text-neutral-400 text-xs" x-text="item.category"></p>
                            </div>
                            <span class="text-neutral-500 text-xs px-2 py-1 bg-neutral-700 rounded"
                                  x-text="item.type === 'service' ? 'Layanan' : item.type === 'category' ? 'Kategori' : 'Developer'">
                            </span>
                        </a>
                    </template>
                    
                    <!-- Search all link -->
                    <a :href="'/search?q=' + encodeURIComponent(query)"
                       class="flex items-center gap-3 px-4 py-3 bg-neutral-700/50 hover:bg-neutral-700 transition border-t border-neutral-700">
                        <span class="text-red-400">🔍</span>
                        <span class="text-neutral-300">Cari "<span class="text-white font-medium" x-text="query"></span>"</span>
                    </a>
                </div>
            </form>
        </div>

        <div class="hidden md:flex md:gap-9 md:items-center">

        <div class="flex items-center gap-5">
            <a href="{{ url('/chat') }}">
                    <img src="{{ asset('gambar/lov.png') }}" width="24">
                </a>
                <a href="{{ url('/cs') }}">
                    <img src="{{ asset('gambar/cart.png') }}" width="24">
                </a>
                <a href="{{ url('/edu') }}">
                    <img src="{{ asset('gambar/chat.png') }}" width="24">
                </a>
        </div>

                <div class="relative group border-l border-gray-300 pl-8 hidden">
                    <div class="w-10 h-10 bg-gray-200 rounded-full cursor-pointer flex items-center justify-center">
                        <img src="{{ asset('gambar/logo.png') }}" class="w-6 h-6">
                    </div>

                    <div class="absolute right-0 mt-2 w-40 bg-white shadow-lg rounded-md 
                                border border-gray-200 hidden group-hover:block">
                        <ul class="py-4 text-sm text-gray-700">
                            <li><a href="{{ url('/profile') }}" class="block px-4 py-2 hover:bg-gray-100">Profile</a></li>
                            <li><a href="{{ url('/') }}" class="block px-4 py-2 bg-red-600 text-white hover:text-white hover:bg-red-700 font-bold hover:bg-gray-100">Jelajahi Developer</a></li>
                            <li><a href="{{ url('/settings') }}" class="block px-4 py-2 hover:bg-gray-100">Settings</a></li>
                            <li><a href="{{ url('/logout') }}" class="block px-4 py-2 hover:bg-gray-100 text-red-500">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>

        <button id="menu-toggle" class="md:hidden text-white focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    <div id="mobile-menu" class="hidden md:hidden bg-neutral-900 border-t border-neutral-700 w-full">

        <div class="p-4">
            <form action="{{ url('/search') }}" method="GET">
                <div class="flex bg-neutral-800 border border-neutral-700 rounded-lg overflow-hidden">
                    <input type="text"
                           name="q"
                           placeholder="Cari layanan..."
                           class="w-full px-4 py-2 bg-neutral-800 text-white focus:outline-none">
                    <button class="px-4 bg-red-700 text-white font-semibold">Cari</button>
                </div>
            </form>
        </div>

        <ul class="flex flex-col p-4 space-y-3">

            <li><a href="{{ url('/') }}" class="text-white text-sm hover:text-red-400 font-medium">Project</a></li>
            <li><a href="{{ url('/Gallery') }}" class="text-white text-sm hover:text-red-400 font-medium">Gallery</a></li>
            <li><a href="{{ url('/About us') }}" class="text-white text-sm hover:text-red-400 font-medium">About us</a></li>
            <li><a href="{{ url('/Contact us') }}" class="text-white text-sm hover:text-red-400 font-medium">Contact us</a></li>

            <hr class="border-neutral-700">

            @auth
                <li class="pt-2 border-t border-neutral-700 mt-2">
                    <div class="flex items-center gap-3 px-2 mb-3">
                        <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('gambar/logo.png') }}" 
                             class="w-8 h-8 rounded-full">
                        <span class="text-white font-medium">{{ Auth::user()->name }}</span>
                    </div>
                </li>
                <li><a href="{{ url('/profile') }}" class="text-white text-sm hover:text-red-400 font-medium block px-2">Profile</a></li>
                <li><a href="{{ url('/logout') }}" class="text-red-500 text-sm hover:text-red-400 font-medium block px-2">Logout</a></li>
            @else
                <li><a href="{{ url('/login') }}" class="text-white text-sm hover:text-red-400 font-medium">Login</a></li>
                <li>
                    <a href="{{ url('/register') }}"
                       class="text-white text-sm hover:text-red-400 font-medium">
                        Daftar
                    </a>
                </li>
            @endauth

            <li>
                <a href="{{ url('/cart') }}" class="flex items-center space-x-2 text-white text-sm hover:text-red-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                         fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6 6h15l-1.5 9h-12z"/>
                        <circle cx="9" cy="20" r="1"/>
                        <circle cx="18" cy="20" r="1"/>
                    </svg>
                    <span>Keranjang</span>
                </a>
            </li>
        </ul>
    </div>
</nav>

<script>
document.getElementById("menu-toggle").addEventListener("click", () => {
    document.getElementById("mobile-menu").classList.toggle("hidden");
});
</script>

<script>
    document.getElementById('menu-toggle').addEventListener('click', () => {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
</script>

<script>
function searchAutocomplete() {
    return {
        query: '',
        suggestions: [],
        showSuggestions: false,
        selectedIndex: -1,
        
        async fetchSuggestions() {
            if (this.query.length < 2) {
                this.suggestions = [];
                return;
            }
            
            try {
                const response = await fetch(`/api/suggestions?q=${encodeURIComponent(this.query)}`);
                this.suggestions = await response.json();
                this.selectedIndex = -1;
            } catch (error) {
                console.error('Failed to fetch suggestions:', error);
                this.suggestions = [];
            }
        },
        
        navigateDown() {
            if (this.selectedIndex < this.suggestions.length) {
                this.selectedIndex++;
            }
        },
        
        navigateUp() {
            if (this.selectedIndex > -1) {
                this.selectedIndex--;
            }
        },
        
        selectCurrent(event) {
            if (this.selectedIndex >= 0 && this.selectedIndex < this.suggestions.length) {
                event.preventDefault();
                window.location.href = this.suggestions[this.selectedIndex].url;
            }
            // If no selection, let form submit normally
        }
    }
}
</script>
</body>
</html>