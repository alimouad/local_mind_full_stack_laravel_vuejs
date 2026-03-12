<script setup>
import { computed, onMounted, ref } from 'vue';
import { RouterLink } from 'vue-router';
import axiosClient from '@/axios.js';
import AdminLayout from '@/layouts/AdminLayout.vue';

const loading = ref(true);
const errorMessage = ref('');

const dashboard = ref({
    totals: {
        questions: 0,
        answers: 0,
        new_users: 0,
    },
    recent_questions: [],
});

const totalQuestions = computed(() => dashboard.value.totals.questions ?? 0);
const totalAnswers = computed(() => dashboard.value.totals.answers ?? 0);
const newUsers = computed(() => dashboard.value.totals.new_users ?? 0);
const recentQuestions = computed(() => dashboard.value.recent_questions ?? []);

function formatNumber(value) {
    return new Intl.NumberFormat().format(value ?? 0);
}

function relativeDate(value) {
    if (!value) return 'Unknown';

    const date = new Date(value);
    const now = new Date();
    const seconds = Math.floor((now.getTime() - date.getTime()) / 1000);

    if (seconds < 60) return 'Just now';

    const minutes = Math.floor(seconds / 60);
    if (minutes < 60) return `${minutes} min ago`;

    const hours = Math.floor(minutes / 60);
    if (hours < 24) return `${hours} h ago`;

    const days = Math.floor(hours / 24);
    if (days < 7) return `${days} d ago`;

    return date.toLocaleDateString();
}

function avatarUrl(name) {
    const safeName = name || 'Unknown';
    return `https://ui-avatars.com/api/?name=${encodeURIComponent(safeName)}&background=f1f5f9&color=64748b`;
}

async function loadDashboard() {
    loading.value = true;
    errorMessage.value = '';

    try {
        const response = await axiosClient.get('/admin/home');
        dashboard.value = response.data;
    } catch (error) {
        errorMessage.value = error.response?.data?.message ?? 'Failed to load admin dashboard.';
    } finally {
        loading.value = false;
    }
}

onMounted(loadDashboard);
</script>

<template>
<AdminLayout>
    <div class="space-y-10 animate-in fade-in slide-in-from-bottom-6 duration-700">
        
        <div v-if="loading" class="flex flex-col items-center justify-center min-h-[400px] rounded-[3rem] bg-white border border-slate-100 shadow-sm">
            <div class="w-12 h-12 border-4 border-emerald-500 border-t-transparent rounded-full animate-spin mb-4"></div>
            <p class="text-slate-400 font-bold uppercase tracking-widest text-xs">Syncing Dashboard...</p>
        </div>

        <div v-else-if="errorMessage" class="rounded-[2.5rem] border-2 border-dashed border-red-200 bg-red-50/30 p-12 text-center">
            <div class="inline-flex p-4 rounded-2xl bg-white shadow-sm text-red-500 mb-4">
                <span class="material-symbols-outlined text-3xl">error</span>
            </div>
            <h3 class="text-xl font-black text-slate-900">{{ errorMessage }}</h3>
            <button @click="window.location.reload()" class="mt-4 px-6 py-2 bg-slate-900 text-white rounded-full text-xs font-black uppercase tracking-widest">Retry</button>
        </div>

        <template v-else>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="group relative bg-white p-8 rounded-[2.5rem] border border-slate-200/60 shadow-2xl shadow-slate-200/40 hover:shadow-emerald-500/10 hover:-translate-y-2 transition-all duration-500">
                    <div class="relative z-10">
                        <div class="flex justify-between items-center mb-8">
                            <div class="w-14 h-14 bg-emerald-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-200 group-hover:rotate-[10deg] transition-transform duration-500">
                                <span class="material-symbols-outlined text-3xl">quiz</span>
                            </div>
                            <div class="flex flex-col items-end">
                                <span class="flex items-center gap-1 text-emerald-600 text-[11px] font-black bg-emerald-50 px-2 py-1 rounded-lg">
                                    <span class="material-symbols-outlined text-sm">trending_up</span>
                                    +12%
                                </span>
                            </div>
                        </div>
                        <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Global Queries</p>
                        <div class="flex items-baseline gap-2">
                            <h3 class="text-5xl font-black text-slate-900 tracking-tighter">{{ formatNumber(totalQuestions) }}</h3>
                            <span class="text-xs font-bold text-slate-300">live</span>
                        </div>
                    </div>
                </div>

                <div class="group relative bg-white p-8 rounded-[2.5rem] border border-slate-200/60 shadow-2xl shadow-slate-200/40 hover:shadow-blue-500/10 hover:-translate-y-2 transition-all duration-500">
                    <div class="relative z-10">
                        <div class="flex justify-between items-center mb-8">
                            <div class="w-14 h-14 bg-blue-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-200 group-hover:-rotate-[10deg] transition-transform duration-500">
                                <span class="material-symbols-outlined text-3xl">forum</span>
                            </div>
                            <div class="flex flex-col items-end">
                                <span class="flex items-center gap-1 text-blue-600 text-[11px] font-black bg-blue-50 px-2 py-1 rounded-lg">
                                    <span class="material-symbols-outlined text-sm">auto_graph</span>
                                    Stable
                                </span>
                            </div>
                        </div>
                        <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Community Help</p>
                        <div class="flex items-baseline gap-2">
                            <h3 class="text-5xl font-black text-slate-900 tracking-tighter">{{ formatNumber(totalAnswers) }}</h3>
                            <span class="text-xs font-bold text-slate-300">replies</span>
                        </div>
                    </div>
                </div>

                <div class="group relative bg-white p-8 rounded-[2.5rem] border border-slate-200/60 shadow-2xl shadow-slate-200/40 hover:shadow-rose-500/10 hover:-translate-y-2 transition-all duration-500">
                    <div class="relative z-10">
                        <div class="flex justify-between items-center mb-8">
                            <div class="w-14 h-14 bg-rose-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-rose-200 group-hover:scale-110 transition-transform duration-500">
                                <span class="material-symbols-outlined text-3xl">person_add</span>
                            </div>
                            <div class="flex flex-col items-end">
                                <span class="text-rose-600 text-[10px] font-black bg-rose-50 px-2 py-1 rounded-lg uppercase tracking-tighter">New Peak</span>
                            </div>
                        </div>
                        <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">New Students</p>
                        <div class="flex items-baseline gap-2">
                            <h3 class="text-5xl font-black text-slate-900 tracking-tighter">{{ formatNumber(newUsers) }}</h3>
                            <span class="text-xs font-bold text-slate-300">joined</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[3rem] border border-slate-200/60 shadow-2xl shadow-slate-200/30 overflow-hidden ring-1 ring-black/[0.02]">
                <div class="px-10 py-10 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <h3 class="text-2xl font-black text-slate-900 tracking-tight">Recent Activity</h3>
                        </div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em]">Live Feed Overview</p>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
                            <input type="text" placeholder="Filter questions..." class="pl-11 pr-4 py-3 bg-slate-50 border-none rounded-2xl text-xs font-bold focus:ring-2 focus:ring-emerald-500/20 w-64 transition-all">
                        </div>
                        <RouterLink to="/admin/questions" class="flex items-center gap-2 px-6 py-3.5 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.15em] hover:bg-emerald-600 transition-all shadow-lg shadow-slate-200 hover:shadow-emerald-200">
                            Manage All
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </RouterLink>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-y border-slate-50 bg-slate-50/30">
                                <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Author</th>
                                <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Question Details</th>
                                <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Post Time</th>
                                <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Action</th>
                            </tr>
                        </thead>

                        <tbody v-if="recentQuestions.length > 0" class="divide-y divide-slate-50">
                            <tr v-for="question in recentQuestions" :key="question.id" class="group hover:bg-slate-50/80 transition-all duration-300">
                                <td class="px-10 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="relative">
                                            <img :src="avatarUrl(question.user?.name)" class="w-10 h-10 rounded-xl border-2 border-white shadow-sm group-hover:scale-110 transition-transform" />
                                            <div class="absolute -top-1 -right-1 w-3 h-3 bg-emerald-500 border-2 border-white rounded-full"></div>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-black text-slate-900 leading-none mb-1">{{ question.user?.name || 'Anonymous' }}</span>
                                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Verified User</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-10 py-6">
                                    <div class="max-w-md">
                                        <span class="text-sm font-bold text-slate-800 line-clamp-1 group-hover:text-emerald-600 transition-colors duration-300">
                                            {{ question.title }}
                                        </span>
                                        <p class="text-[11px] text-slate-400 font-medium truncate mt-0.5">{{ question.content }}</p>
                                    </div>
                                </td>
                                <td class="px-10 py-6">
                                    <div class="flex items-center gap-2 text-slate-500">
                                        <span class="material-symbols-outlined text-sm">schedule</span>
                                        <span class="text-xs font-bold">{{ relativeDate(question.created_at) }}</span>
                                    </div>
                                </td>
                                <td class="px-10 py-6 text-right">
                                    <RouterLink :to="`/question/${question.id}`" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-emerald-500 hover:border-emerald-200 hover:shadow-lg hover:shadow-emerald-100 transition-all">
                                        <span class="material-symbols-outlined">visibility</span>
                                    </RouterLink>
                                </td>
                            </tr>
                        </tbody>

                        <tbody v-else>
                            <tr>
                                <td colspan="4" class="px-10 py-32 text-center">
                                    <div class="flex flex-col items-center opacity-20">
                                        <span class="material-symbols-outlined text-6xl mb-4">Inbox</span>
                                        <p class="text-xl font-black uppercase tracking-widest">Quiet for now</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="px-10 py-6 border-t border-slate-50 bg-slate-50/20 flex justify-between items-center text-[10px] font-black text-slate-400 uppercase tracking-widest">
                    <span>Showing latest activity</span>
                    <div class="flex gap-4">
                        <button class="hover:text-slate-900 transition-colors">Previous</button>
                        <button class="hover:text-slate-900 transition-colors">Next</button>
                    </div>
                </div>
            </div>
        </template>
    </div>
</AdminLayout>
</template>