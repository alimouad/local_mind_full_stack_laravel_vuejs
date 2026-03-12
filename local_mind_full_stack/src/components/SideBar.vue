<script setup>
import { computed } from 'vue';
import { RouterLink, useRoute, useRouter } from 'vue-router';
// Ensure axiosClient is correctly imported based on your file structure
import axiosClient from '@/axios.js'; 

const route = useRoute();
const router = useRouter();

const navItems = [
    { to: '/admin/home', icon: 'grid_view', label: 'Dashboard' },
    { to: '/admin/questions', icon: 'quiz', label: 'Questions' },
    { to: '/admin/answers', icon: 'forum', label: 'Answers' },
    { to: '/admin/users', icon: 'badge', label: 'Users' },
];

const activePath = computed(() => route.path);

// Fixed isActive logic to prevent partial string matches
function isActive(path) {
    if (path === '/admin/home') return activePath.value === path;
    return activePath.value.startsWith(path);
}

async function logout() {
    try {
        await axiosClient.post('/logout');
    } catch (error) {
        console.error('Logout failed:', error);
    } finally {
        router.push({ name: 'login' });
    }
}
</script>

<template>
    <aside class="w-72 h-screen sticky top-0 bg-white border-r border-slate-100 flex flex-col p-6 z-50 shadow-[20px_0_30px_rgba(0,0,0,0.01)]">
        <div class="space-y-6 mb-10">
            <div class="flex items-center gap-3 px-2">
                <div class="relative group">
                    <div class="absolute inset-0 bg-emerald-500 blur-xl opacity-20 group-hover:opacity-40 transition-opacity"></div>
                    <div class="relative w-11 h-11 bg-slate-900 rounded-2xl flex items-center justify-center text-white shadow-lg transition-all duration-500 group-hover:rotate-[15deg]">
                        <span class="material-symbols-outlined text-2xl">rocket_launch</span>
                    </div>
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-black tracking-tighter text-slate-900 leading-none">
                        Q<span class="text-emerald-500">uestly</span>
                    </span>
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mt-1">Management</span>
                </div>
            </div>

            <button class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl bg-slate-50 border border-slate-100 text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-all group">
                <span class="material-symbols-outlined text-xl group-hover:scale-110 transition-transform">search</span>
                <span class="text-xs font-bold tracking-wide">Quick Search...</span>
                <kbd class="ml-auto text-[9px] font-black bg-white px-1.5 py-0.5 rounded border border-slate-200">⌘K</kbd>
            </button>
        </div>

        <nav class="space-y-1 flex-1 -mx-2 px-2 overflow-y-auto custom-scrollbar">
            <div class="mb-4 ml-4 text-[10px] font-black text-slate-300 uppercase tracking-[0.3em]">Main Menu</div>
            
            <RouterLink
                v-for="item in navItems"
                :key="item.to"
                :to="item.to"
                class="group relative flex items-center gap-4 px-5 py-3.5 rounded-2xl text-sm font-bold transition-all duration-300"
                :class="isActive(item.to)
                    ? 'bg-slate-900 text-white shadow-xl shadow-slate-200'
                    : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50'"
            >
                <span 
                    class="material-symbols-outlined transition-all duration-300"
                    :class="isActive(item.to) ? 'text-emerald-400 scale-110' : 'text-slate-400 group-hover:text-slate-900'"
                >
                    {{ item.icon }}
                </span>
                
                <span class="relative z-10">{{ item.label }}</span>

                <div v-if="isActive(item.to)" class="absolute right-4 w-1.5 h-1.5 bg-emerald-400 rounded-full shadow-[0_0_12px_#34d399]"></div>
            </RouterLink>
        </nav>

        <div class="pt-6 mt-6 border-t border-slate-50 space-y-4">
            <div class="flex items-center gap-3 p-3 rounded-2xl bg-slate-50 border border-slate-100 group cursor-pointer hover:bg-white hover:shadow-md transition-all">
                <div class="relative">
                    <img src="https://ui-avatars.com/api/?name=Admin+User&background=10b981&color=fff" class="w-10 h-10 rounded-xl object-cover" />
                    <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-2 border-white rounded-full"></div>
                </div>
                <div class="flex flex-col overflow-hidden">
                    <span class="text-xs font-black text-slate-900 truncate">Alex Rivera</span>
                    <span class="text-[10px] font-bold text-slate-400 truncate">Super Admin</span>
                </div>
                <span class="material-symbols-outlined ml-auto text-slate-300 text-lg group-hover:text-slate-900 transition-colors">unfold_more</span>
            </div>

            <button
                @click="logout"
                class="w-full flex items-center justify-center gap-3 px-5 py-4 rounded-2xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-all duration-500 group font-black text-xs uppercase tracking-widest"
            >
                <span class="material-symbols-outlined text-lg group-hover:-translate-x-1 transition-transform">logout</span>
                Sign Out System
            </button>
        </div>
    </aside>
</template>

<style scoped>
/* 1. Import MUST be at the top */
@import url('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200');

/* 2. Base style for the icons */
.material-symbols-outlined {
  display: inline-block;
  font-family: 'Material Symbols Outlined'; /* Explicitly set the font family */
  font-weight: normal;
  font-style: normal;
  font-size: 24px;
  line-height: 1;
  letter-spacing: normal;
  text-transform: none;
  white-space: nowrap;
  word-wrap: normal;
  direction: ltr;
  -webkit-font-feature-settings: 'liga';
    font-feature-settings: 'liga';
  -webkit-font-smoothing: antialiased;
  
  /* Your custom variations */
  font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24;
}

/* 3. Style for active link icons */
.router-link-active .material-symbols-outlined {
  font-variation-settings: 'FILL' 1, 'wght' 600, 'GRAD' 0, 'opsz' 24;
}

/* ... existing scrollbar styles ... */
</style>