{{-- Student Sidebar --}}
<aside class="w-72 h-screen sticky top-0 bg-white border-r border-emerald-50 flex flex-col p-6 z-50">

    {{-- Brand Logo --}}
    <div class="flex items-center gap-3 mb-10 px-4">
        <div class="w-11 h-11 bg-gradient-to-br from-emerald-400 to-student rounded-2xl flex items-center justify-center text-white shadow-xl shadow-emerald-100 transition-transform hover:rotate-6">
            <span class="material-symbols-outlined text-2xl font-bold">rocket_launch</span>
        </div>
        <span class="text-xl font-black tracking-tighter italic text-slate-800">
            Q<span class="text-student">uestly</span>
        </span>
    </div>

    {{-- Navigation --}}
    <nav class="space-y-2 flex-1">

        {{-- Dashboard --}}
        <x-sidebar-link 
            href="/admin/home"
            icon="layout-dashboard"
            label="Dashboard"
            :active="request()->is('admin/home*')"
        />

        {{-- Questions --}}
        <x-sidebar-link 
            href="/admin/questions"
            icon="scroll-text"
            label="Questions"
            :active="request()->is('admin/questions*')"
        />

        {{-- Answers --}}
        <x-sidebar-link 
            href="/admin/answers"
            icon="send"
            label="Answers"
            :active="request()->is('admin/answers*')"
        />

        {{-- Favorites --}}
        <x-sidebar-link 
            href="/admin/users"
            icon="star"
            label="Users"
            :active="request()->is('admin/users*')"
        />

    </nav>

    {{-- Logout --}}
    <div class="pt-6 border-t border-slate-50">
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="flex items-center gap-4 px-6 py-4 rounded-2xl text-slate-400 hover:text-rose-500 hover:bg-rose-50 transition-all duration-300 group">
            <span class="material-symbols-outlined group-hover:scale-110 transition-transform">logout</span>
            <span class="text-sm font-bold">Sign Out</span>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>

</aside>
