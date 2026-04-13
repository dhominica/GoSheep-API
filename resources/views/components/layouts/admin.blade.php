@props(['title' => 'Dashboard', 'header' => 'Dashboard'])
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }} | GoSheep Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .glass-panel {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 flex h-screen overflow-hidden relative" x-data="{ sidebarOpen: window.innerWidth >= 768 }">
    
    <!-- Decorative Background Splashes for Premium Feel -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute top-[10%] left-[10%] w-[40%] h-[40%] rounded-full bg-green-400/10 blur-[120px]"></div>
        <div class="absolute bottom-[10%] right-[5%] w-[35%] h-[35%] rounded-full bg-teal-400/10 blur-[100px]"></div>
    </div>

    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" x-cloak 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 md:hidden" 
         @click="sidebarOpen = false"></div>

    <!-- Sidebar Layout (White Theme) -->
    <!-- We animate the width on desktop seamlessly. On mobile it uses translation -->
    <aside :class="sidebarOpen ? 'translate-x-0 w-[260px]' : '-translate-x-full md:translate-x-0 md:w-0 md:opacity-0'" 
           class="fixed md:static inset-y-0 left-0 z-50 bg-white border-r border-slate-200 flex flex-col transition-all duration-300 ease-[cubic-bezier(0.4,0,0.2,1)] shadow-[0_0_40px_-15px_rgba(0,0,0,0.1)] md:shadow-none overflow-hidden shrink-0 group">
        
        <div class="h-[64px] flex items-center justify-between px-5 border-b border-slate-100 shrink-0 w-[260px]">
            <div class="flex items-center gap-3">
                <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-[2px] rounded-lg shadow-sm">
                    <div class="bg-white p-1 rounded-md">
                        <img src="{{ asset('assets/img/logo_app.png') }}" alt="GoSheep" class="w-5 h-5 object-contain">
                    </div>
                </div>
                <span class="text-xl font-extrabold tracking-tight text-slate-800">GoSheep</span>
            </div>
            <!-- Close Mobile -->
            <button @click="sidebarOpen = false" class="md:hidden p-1.5 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-100 transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        
        <nav class="flex-1 overflow-y-auto py-5 px-3 space-y-1 w-[260px] overflow-x-hidden">
            
            <x-sidebar-link href="{{ route('dashboard') }}" icon="layout-dashboard" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-sidebar-link>
            
            <p class="px-3 pt-5 pb-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Master Data</p>
            
            <x-sidebar-link href="#" icon="tent" :active="request()->is('kandang*')">
                Kandang
            </x-sidebar-link>

            <x-sidebar-link href="#" icon="logo" :active="request()->is('domba*')">
                Ternak Domba
            </x-sidebar-link>
            
            <p class="px-3 pt-5 pb-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pencatatan</p>
            
            <x-sidebar-link href="#" icon="heart-pulse" :active="request()->is('kesehatan*')">
                Kesehatan
            </x-sidebar-link>

            <x-sidebar-link href="#" icon="git-merge" :active="request()->is('mating*')">
                Persilangan (Mating)
            </x-sidebar-link>

            <x-sidebar-link href="#" icon="scale" :active="request()->is('berat*')">
                Riwayat Berat
            </x-sidebar-link>

            <p class="px-3 pt-5 pb-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Lainnya</p>

            <x-sidebar-link href="{{ route('profile') }}" icon="user" :active="request()->routeIs('profile')">
                Profil Saya
            </x-sidebar-link>

            <!-- Split Pengguna menus based on role -->
            <x-sidebar-link href="{{ route('peternak.index') }}" icon="smartphone" :active="request()->is('peternak*')">
                Akun Peternak
            </x-sidebar-link>

            @if(Auth::check() && Auth::user()->role === 'owner')
                <x-sidebar-link href="{{ route('admin-users.index') }}" icon="users" :active="request()->is('admin-users*')">
                    Akun Admin & Owner
                </x-sidebar-link>
            @endif
            
            <div class="h-4"></div>
        </nav>
        
        <div class="p-4 border-t border-slate-100 shrink-0 w-[260px] bg-slate-50/50">
            <div class="flex items-center gap-3 px-2 py-2 mb-2">
                <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-green-500 to-teal-400 flex items-center justify-center font-bold text-sm text-white shadow-sm">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="overflow-hidden">
                    <h4 class="font-bold text-sm leading-tight text-slate-800 truncate">{{ Auth::user()->name }}</h4>
                    <p class="text-[11px] text-slate-500 capitalize truncate font-semibold mt-0.5">{{ Auth::user()->role }}</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex w-full items-center gap-2 px-3 py-2 bg-white hover:bg-red-50 text-slate-600 hover:text-red-600 border border-slate-200 hover:border-red-200 rounded-lg justify-center transition-all duration-200 text-xs font-bold group">
                    <i data-lucide="log-out" class="w-3.5 h-3.5 group-hover:scale-110 transition-transform"></i>
                    Keluar Sistem
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col min-w-0 overflow-hidden relative transition-all duration-300">
        
        <!-- Mobile Header -->
        <header class="h-[64px] bg-white border-b border-slate-200 flex md:hidden items-center justify-between px-4 z-30 shrink-0 sticky top-0 shadow-sm">
            <div class="flex items-center gap-2">
                <button @click="sidebarOpen = true" class="p-1.5 text-slate-500 hover:text-green-600 rounded-lg hover:bg-green-50 transition-colors">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                <div class="flex items-center gap-2">
                    <img src="{{ asset('assets/img/logo_app.png') }}" alt="GoSheep" class="w-5 h-5 object-contain">
                    <span class="text-lg font-extrabold text-green-700 tracking-tight">GoSheep</span>
                </div>
            </div>
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-green-500 to-teal-500 text-white flex items-center justify-center font-bold text-sm shadow-sm">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        </header>

        <!-- Desktop Header -->
        <header class="h-[64px] bg-white/80 backdrop-blur-md border-b border-slate-200/60 hidden md:flex items-center justify-between px-6 z-10 shrink-0 transition-all sticky top-0">
            <div class="flex items-center gap-4">
                <!-- Sidebar Toggle Button -->
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 text-slate-400 hover:text-green-600 bg-slate-50 hover:bg-green-50 rounded-xl transition-all shadow-sm border border-slate-100">
                    <i data-lucide="sidebar" class="w-4 h-4"></i>
                </button>
                <h1 class="text-lg font-bold text-slate-800 tracking-tight">{{ $header ?? 'Dashboard' }}</h1>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="hidden lg:flex items-center bg-slate-100 hover:bg-slate-200/80 border border-slate-200 rounded-lg px-3 py-1.5 transition-colors focus-within:ring-2 ring-green-500/20 focus-within:border-green-500">
                    <i data-lucide="search" class="w-3.5 h-3.5 text-slate-400"></i>
                    <input type="text" placeholder="Cari data..." class="bg-transparent border-none outline-none text-xs ml-2 w-40 text-slate-700 placeholder-slate-400">
                </div>

                <div class="flex space-x-2">
                    <button class="p-2 text-slate-400 hover:text-green-600 bg-slate-50 hover:bg-green-50 rounded-lg transition-all shadow-sm border border-slate-100 relative group overflow-hidden">
                        <i data-lucide="bell" class="w-4 h-4 group-hover:scale-110 transition-transform"></i>
                        <span class="absolute top-1.5 right-1.5 w-1.5 h-1.5 bg-rose-500 rounded-full border border-white animate-pulse"></span>
                    </button>
                </div>
                
                <div class="h-6 w-px bg-slate-200"></div>

                <div class="flex items-center gap-3">
                    <div class="text-right hidden lg:block">
                        <p class="text-xs font-bold text-slate-700 leading-none">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] font-bold text-green-600 mt-1 uppercase tracking-wider">{{ Auth::user()->role }} Mode</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="flex-1 overflow-y-auto px-4 md:px-6 pb-8 pt-4 md:pt-6 scroll-smooth">
            <div class="max-w-[1300px] mx-auto space-y-5">
                {{ $slot }}
            </div>
        </div>
    </main>

    <script>
        // Init Lucide and watch for alpine dom changes if needed
        document.addEventListener('alpine:init', () => {
            Lucide.createIcons();
        });
        lucide.createIcons();

        // Global SweetAlert2 logic for forms with class "delete-form"
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForms = document.querySelectorAll('.delete-form');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                      title: "Apakah Anda yakin?",
                      text: "Data yang dihapus tidak dapat dikembalikan!",
                      icon: "warning",
                      showCancelButton: true,
                      confirmButtonColor: "#10b981",
                      cancelButtonColor: "#f43f5e",
                      confirmButtonText: "Ya, hapus permanen!",
                      cancelButtonText: "Batal"
                    }).then((result) => {
                      if (result.isConfirmed) {
                        form.submit();
                      }
                    });
                });
            });
        });
    </script>
</body>
</html>
