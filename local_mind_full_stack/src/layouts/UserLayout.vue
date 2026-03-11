<script setup>
import Header from '@/components/Header.vue';

</script>
<template>
    <div class="h-full antialiased text-slate-900 flex flex-col">

    <Header />

    <main class="flex-grow py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <slot></slot>
        </div>
    </main>

    <footer class="py-6 bg-white border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2">
                <div class="h-6 w-6 rounded bg-primary flex items-center justify-center">
                    <span class="text-white text-[10px] font-bold">Q</span>
                </div>
                <span class="text-sm font-bold text-slate-800 tracking-tight">Questly</span>
            </div>
            <p class="text-s font-medium text-slate-400">
                &copy; {{ new Date().getFullYear() }} — Engineered for explorers.
            </p>
        </div>
    </footer>
    </div>

</template>