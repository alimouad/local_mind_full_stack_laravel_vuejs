<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal | @yield('title', 'My Progress')</title>
    
    {{-- Core Assets --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { 
                        primary: '#ff4f7a', 
                        student: '#10b981', 
                        accent: '#14b8a6',
                        panel: '#f0f9f6'
                    },
                    fontFamily: { sans: ['Poppins', 'sans-serif'] },
                }
            }
        }
    </script>
    
    <style>
        .glass { background: rgba(255, 255, 255, 0.75); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        .emerald-glow { box-shadow: 0 10px 30px -10px rgba(16, 185, 129, 0.2); }

    </style>
</head>

<body class="bg-panel font-sans h-full overflow-hidden text-slate-900 antialiased">
    
    <div class="flex h-full w-full overflow-hidden">
        
        {{-- Sidebar --}}
        @include('partials.sidebarAdmin')

        {{-- Main Content Area --}}
        <main class="flex-1 h-full overflow-y-auto relative scroll-smooth flex flex-col">
            
            {{-- Floating Top Navbar --}}
            <header class="sticky top-0 z-40 glass border-b border-emerald-100/50 px-8 lg:px-12 py-4 flex items-center justify-between min-h-[80px]">
                
                <div class="flex items-center gap-4">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    <div class="flex flex-col">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] leading-none">Status Center</span>
                        <span class="text-xs font-bold text-slate-600 mt-1">
                            {{ session('sprint_title') ?? 'Global Academic Cycle' }}
                        </span>
                    </div>
                </div>
                
                <div class="flex items-center gap-6">
                    {{-- Notifications --}}
                    <button class="relative w-11 h-11 flex items-center justify-center rounded-2xl bg-white border border-slate-100 text-slate-400 hover:text-emerald-500 hover:border-emerald-200 transition-all duration-300 shadow-sm">
                        <span class="absolute top-3 right-3 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white"></span>
                        <span class="material-symbols-outlined text-xl">notifications</span>
                    </button>
                    
                    {{-- User Profile --}}
                    <div class="flex items-center gap-4 pl-6 border-l border-slate-200">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-bold text-slate-800 leading-none mb-1">
                                {{ auth()->user()->name ?? 'Admin' }}
                            </p>
                            <p class="text-[10px] font-extrabold text-emerald-500 uppercase tracking-widest">
                               Admin
                            </p>
                        </div>
                        
                        {{-- Smart Avatar --}}
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-50 to-emerald-100 border-2 border-white shadow-sm flex items-center justify-center text-emerald-700 font-bold overflow-hidden transition-transform hover:rotate-3">
                            @if(auth()->user() && auth()->user()->avatar)
                                <img src="{{ auth()->user()->avatar }}" class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr(auth()->user()->name ?? 'S', 0, 2)) }}
                            @endif
                        </div>
                    </div>
                </div>
            </header>

            {{-- Main Scrollable Content --}}
            <div class="p-8 lg:p-12 w-full max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>
    </div>

</body>
</html>