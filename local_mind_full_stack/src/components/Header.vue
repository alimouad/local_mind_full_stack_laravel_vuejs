<script setup>
import axiosClient from "@/axios.js";
import { useRouter } from "vue-router";

const router = useRouter();

function logout() {
    axiosClient.post('/logout')
        .then(() => {
            router.push({name: 'login'});
        })
        .catch(error => {
            console.error('Logout failed:', error);
        });
}

</script>
<template>
    <nav class="sticky top-0 z-[10000] w-full glass-nav border-b border-slate-200/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">

                <div class="flex items-center gap-10">
                    <RouterLink to="/" class="flex items-center gap-2.5 group">
                        <div
                            class="h-10 w-10 rounded-xl bg-primary flex items-center justify-center shadow-lg shadow-emerald-200 group-hover:rotate-6 transition-transform duration-300">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span
                            class="text-xl font-extrabold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-slate-600">
                            Questly
                        </span>
                    </RouterLink>

                    <div class="hidden md:flex items-center gap-1">
                        <RouterLink to="/home"
                            class="px-4 py-2 rounded-lg text-sm font-semibold text-slate-600 hover:bg-emerald-50 hover:text-primary transition-all">
                            Feed</RouterLink>
                        <RouterLink to="/favorites"
                            class="px-4 py-2 rounded-lg text-sm font-semibold text-slate-600 hover:bg-emerald-50 hover:text-primary transition-all">
                            Favorites</RouterLink>

                    </div>
                </div>

                <div class="flex items-center gap-5">
                    <div class="flex items-center gap-3 pl-4 border-l border-slate-200">
                        <div class="hidden sm:flex flex-col items-end">
                            <span class="text-sm font-bold text-slate-800">Guest User
                            </span>
                            <span class="text-[10px] uppercase tracking-widest font-bold text-primary">Explorer</span>
                        </div>
                        <button class="relative group">
                            <div
                                class="h-10 w-10 rounded-xl border-2 border-white shadow-md overflow-hidden group-hover:border-emerald-200 transition-all">
                                <img src="https://ui-avatars.com/api/?name=u&background=059669&color=fff"
                                    alt="Avatar">
                            </div>
                        </button>


                        <button type="submit" @click='logout'
                            class="group flex items-center justify-center w-9 h-9 rounded-lg bg-slate-100 text-slate-500 hover:bg-red-50 hover:text-red-600 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

</template>