<script setup>
import UserLayout from '@/layouts/UserLayout.vue';
import axiosClient from '@/axios.js';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const form = ref({
    title: '',
    content: '',
    location: '',
    latitude: '',
    longitude: '',
});

const errors = ref({});
const success = ref('');
const loading = ref(false);

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

function showPosition(position) {
    form.value.latitude = position.coords.latitude;
    form.value.longitude = position.coords.longitude;
    form.value.location = "My Current Location";
}

function submitQuestion() {
    errors.value = {};
    loading.value = true;

    axiosClient.post('/questions', form.value)
        .then(response => {
            success.value = 'Question posted successfully!';
            setTimeout(() => {
                router.push({ name: 'home' });
            }, 1500);
        })
        .catch(error => {
            if (error.response?.data?.errors) {
                errors.value = error.response.data.errors;
            } else {
                errors.value.general = error.response?.data?.message ?? 'Failed to post question.';
            }
        })
        .finally(() => {
            loading.value = false;
        });
}
</script>

<template>
    <UserLayout>
        <div class="max-w-4xl mx-auto px-4 py-8">

            <div v-if="success" class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 text-sm font-medium">
                {{ success }}
            </div>

            <div v-if="errors.general" class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 text-sm font-medium">
                {{ errors.general }}
            </div>

          <nav class="flex mb-8 text-sm" aria-label="Breadcrumb">
    <ol class="flex items-center space-x-3 bg-white/50 backdrop-blur-sm px-4 py-2 rounded-full border border-slate-200/60 shadow-sm">
        <li>
            <RouterLink to="/home" class="text-slate-500 hover:text-primary transition-colors flex items-center gap-1.5 font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                Dashboard
            </RouterLink>
        </li>
        <li class="text-slate-300">
            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" /></svg>
        </li>
        <li class="text-slate-900 font-bold tracking-tight">New Question</li>
    </ol>
</nav>

<form @submit.prevent="submitQuestion" class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500" novalidate>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200/60 shadow-xl shadow-slate-200/30 ring-1 ring-black/[0.02]">
                <div class="flex items-center gap-3 mb-8">
                    <div class="p-2.5 bg-primary/10 text-primary rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight">Question Details</h3>
                </div>

                <div class="space-y-6">
                    <div class="group">
                        <label for="title" class="block text-sm font-bold text-slate-700 mb-2 ml-1 transition-colors group-focus-within:text-primary">
                            Question Title
                        </label>
                        <input v-model="form.title" type="text" id="title"
                            placeholder="e.g. Is the Main St. intersection currently flooded?"
                            class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-2 border-transparent focus:bg-white focus:border-primary/20 focus:ring-4 focus:ring-primary/5 transition-all outline-none text-slate-800 placeholder-slate-400 font-medium shadow-inner"
                            :class="{ '!border-red-500 !ring-red-500/5': errors.title }">
                        <p v-if="errors.title" class="text-xs text-red-600 mt-2 ml-2 font-bold flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                            {{ errors.title?.[0] }}
                        </p>
                    </div>

                    <div class="group">
                        <div class="flex justify-between items-end mb-2 ml-1">
                            <label for="content" class="text-sm font-bold text-slate-700 group-focus-within:text-primary transition-colors">Additional Context</label>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Optional</span>
                        </div>
                        <textarea v-model="form.content" id="content" rows="8"
                            placeholder="Provide more details to help the community understand the situation..."
                            class="w-full px-6 py-4 rounded-3xl bg-slate-50 border-2 border-transparent focus:bg-white focus:border-primary/20 focus:ring-4 focus:ring-primary/5 transition-all outline-none text-slate-800 placeholder-slate-400 font-medium shadow-inner resize-none"
                            :class="{ '!border-red-500 !ring-red-500/5': errors.content }"></textarea>
                        <p v-if="errors.content" class="text-xs text-red-600 mt-2 ml-2 font-bold flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                            {{ errors.content?.[0] }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">
            <div class="bg-slate-900 p-8 rounded-[2.5rem] shadow-2xl shadow-slate-900/20 text-white relative overflow-hidden group">
                <div class="absolute -top-24 -right-24 w-48 h-48 bg-primary/20 rounded-full blur-3xl group-hover:bg-primary/30 transition-colors"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="p-2 bg-white/10 rounded-xl backdrop-blur-md">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-black tracking-tight">Set Location</h3>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2">Location Name</label>
                            <input v-model="form.location" type="text" placeholder="e.g. Central Park, NY"
                                class="w-full px-4 py-3 text-sm rounded-xl bg-white/10 border border-white/10 focus:border-primary focus:ring-0 outline-none transition-all placeholder-slate-500 font-medium"
                                :class="{ '!border-red-500': errors.location }">
                            <p v-if="errors.location" class="text-[10px] text-red-400 mt-2 font-bold">{{ errors.location?.[0] }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white/5 p-3 rounded-2xl border border-white/5">
                                <label class="block text-[9px] font-black uppercase tracking-widest text-slate-500 mb-1">Latitude</label>
                                <code class="text-xs font-mono font-bold text-primary">{{ form.latitude || '0.0000' }}</code>
                            </div>
                            <div class="bg-white/5 p-3 rounded-2xl border border-white/5">
                                <label class="block text-[9px] font-black uppercase tracking-widest text-slate-500 mb-1">Longitude</label>
                                <code class="text-xs font-mono font-bold text-primary">{{ form.longitude || '0.0000' }}</code>
                            </div>
                        </div>

                        <button type="button" @click="getLocation"
                            class="w-full py-4 text-sm font-black text-white bg-primary/20 border border-primary/30 rounded-2xl hover:bg-primary transition-all active:scale-95 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" /></svg>
                            Auto-Detect
                        </button>
                    </div>
                </div>
            </div>

            <button type="submit" :disabled="loading"
                class="group w-full py-5 bg-primary hover:bg-emerald-600 text-white font-black rounded-[2rem] shadow-xl shadow-emerald-200 transition-all active:scale-95 disabled:opacity-50 disabled:grayscale flex items-center justify-center gap-3">
                <span class="text-lg leading-none">{{ loading ? 'Publishing...' : 'Publish Question' }}</span>
                <svg v-if="!loading" class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 5l7 7-7 7M5 5l7 7-7 7" /></svg>
            </button>
        </div>
    </div>
</form>
        </div>

    </UserLayout>
</template>