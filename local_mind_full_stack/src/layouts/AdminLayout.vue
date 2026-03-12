<script setup>
import { computed } from 'vue';
import SideBar from '@/components/SideBar.vue';

const displayName = computed(() => {
    return localStorage.getItem('user_name') || 'Admin';
});

const initials = computed(() => {
    return displayName.value.slice(0, 2).toUpperCase();
});
</script>

<template>
    <div class="flex h-screen w-full overflow-hidden bg-slate-50">
        <SideBar />

        <main class="flex-1 h-full overflow-y-auto relative scroll-smooth flex flex-col">
            <header
                class="sticky top-0 z-40 glass border-b border-emerald-100/50 px-8 lg:px-12 py-4 flex items-center justify-between min-h-[80px] bg-white/80 backdrop-blur"
            >
                <div class="flex items-center gap-4">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    <div class="flex flex-col">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] leading-none">Status Center</span>
                        <span class="text-xs font-bold text-slate-600 mt-1">Global Academic Cycle</span>
                    </div>
                </div>

                <div class="flex items-center gap-6">
                    <button
                        type="button"
                        class="relative w-11 h-11 flex items-center justify-center rounded-2xl bg-white border border-slate-100 text-slate-400 hover:text-emerald-500 hover:border-emerald-200 transition-all duration-300 shadow-sm"
                    >
                        <span class="absolute top-3 right-3 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white"></span>
                        <span class="material-symbols-outlined text-xl">notifications</span>
                    </button>

                    <div class="flex items-center gap-4 pl-6 border-l border-slate-200">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-bold text-slate-800 leading-none mb-1">{{ displayName }}</p>
                            <p class="text-[10px] font-extrabold text-emerald-500 uppercase tracking-widest">Admin</p>
                        </div>

                        <div
                            class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-50 to-emerald-100 border-2 border-white shadow-sm flex items-center justify-center text-emerald-700 font-bold overflow-hidden transition-transform hover:rotate-3"
                        >
                            {{ initials }}
                        </div>
                    </div>
                </div>
            </header>

            <div class="p-8 lg:p-12 w-full max-w-7xl mx-auto">
                <slot />
            </div>
        </main>
    </div>
</template>