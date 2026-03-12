<script setup>
import { onMounted, ref } from 'vue';
import { RouterLink } from 'vue-router';
import UserLayout from '@/layouts/UserLayout.vue';
import axiosClient from '@/axios.js';

const favourites = ref([]);
const loading = ref(true);
const errorMessage = ref('');

function formatRelativeDate(value) {
    const date = new Date(value);
    const now = new Date();
    const seconds = Math.floor((now.getTime() - date.getTime()) / 1000);

    if (seconds < 60) {
        return 'Just now';
    }

    const minutes = Math.floor(seconds / 60);
    if (minutes < 60) {
        return `${minutes} min ago`;
    }

    const hours = Math.floor(minutes / 60);
    if (hours < 24) {
        return `${hours} h ago`;
    }

    const days = Math.floor(hours / 24);
    if (days < 7) {
        return `${days} d ago`;
    }

    return date.toLocaleDateString();
}

function avatarUrl(question) {
    const name = question.user?.name ?? 'U';
    return `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=059669&color=fff`;
}

async function loadFavourites() {
    loading.value = true;
    errorMessage.value = '';

    try {
        const response = await axiosClient.get('/favourites');
        favourites.value = response.data.data ?? [];
    } catch (error) {
        errorMessage.value = error.response?.data?.message ?? 'Failed to load favourites.';
    } finally {
        loading.value = false;
    }
}

async function removeFavourite(question) {
    try {
        const response = await axiosClient.post(`/questions/${question.id}/favourite`);
        if (response.data.is_favourited === false) {
            favourites.value = favourites.value.filter(item => item.id !== question.id);
        }
    } catch (e) {
        // Silent fail to keep interaction lightweight.
    }
}

async function deleteQuestion(question) {
    if (!confirm('Delete this question? This cannot be undone.')) return;

    try {
        await axiosClient.delete(`/questions/${question.id}`);
        favourites.value = favourites.value.filter(item => item.id !== question.id);
    } catch (e) {
        errorMessage.value = e.response?.data?.message ?? 'Failed to delete question.';
    }
}

onMounted(loadFavourites);
</script>

<template>
    <UserLayout>
        <div class="max-w-5xl mx-auto px-4">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
                <div>
                    <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">My Favourites</h1>
                    <p class="text-slate-500 mt-2 text-lg font-medium">Posts you bookmarked for quick access.</p>
                </div>
                <RouterLink to="/home"
                    class="inline-flex items-center justify-center px-6 py-3.5 bg-slate-900 hover:bg-slate-700 text-white font-bold rounded-2xl shadow-lg transition-all active:scale-[0.98] gap-2 text-[13px]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Feed
                </RouterLink>
            </div>

            <div v-if="loading"
                class="rounded-3xl border border-slate-200/60 bg-white p-8 text-center text-slate-500 shadow-sm">
                Loading favourites...
            </div>

            <div v-else-if="errorMessage"
                class="rounded-3xl border border-red-200 bg-red-50 p-8 text-center text-red-700 shadow-sm">
                {{ errorMessage }}
            </div>

            <div v-else-if="favourites.length === 0"
                class="rounded-3xl border border-slate-200/60 bg-white p-8 text-center text-slate-500 shadow-sm">
                You have no favourite posts yet.
            </div>

            <div v-else class="grid gap-5">
                <div v-for="question in favourites" :key="question.id"
                    class="group bg-white p-1 rounded-3xl border border-slate-200/60 shadow-sm hover:shadow-xl hover:shadow-emerald-900/5 hover:border-emerald-200/50 transition-all duration-300">
                    <div class="p-5 flex flex-col md:flex-row gap-6">
                        <div
                            class="hidden md:flex flex-col items-center justify-center min-w-[90px] h-[90px] rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-2xl font-black text-slate-800">{{ question.answers_count ?? 0 }}</span>
                            <span class="text-[10px] uppercase tracking-widest font-extrabold text-slate-400">Answers</span>
                        </div>

                        <div class="flex-grow flex flex-col">
                            <div class="flex items-center gap-3 mb-3">
                                <span v-if="question.location"
                                    class="inline-flex items-center px-3 py-1 rounded-lg text-[11px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-100/50">
                                    {{ question.location }}
                                </span>
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-tight">
                                    {{ formatRelativeDate(question.created_at) }}
                                </span>
                            </div>

                            <RouterLink :to="'/question/' + question.id" class="group/title">
                                <h2
                                    class="text-xl font-bold text-slate-900 mb-2 leading-tight group-hover/title:text-primary transition-colors">
                                    {{ question.title }}
                                </h2>
                            </RouterLink>

                            <p class="text-slate-500 text-sm leading-relaxed line-clamp-2 mb-5">
                                {{ question.content }}
                            </p>

                            <div class="mt-auto pt-4 border-t border-slate-50 flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <img :src="avatarUrl(question)" class="w-7 h-7 rounded-lg shadow-sm">
                                    <span class="text-xs font-bold text-slate-700">{{ question.user?.name ?? 'Anonymous' }}</span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <button @click.prevent="removeFavourite(question)"
                                        title="Remove from favourites"
                                        class="p-2 rounded-xl text-rose-500 bg-rose-50 hover:bg-rose-100 transition-all">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </button>

                                    <button v-if="question.is_owner" @click.prevent="deleteQuestion(question)"
                                        title="Delete question"
                                        class="p-2 rounded-xl text-slate-400 bg-slate-50 hover:text-red-500 hover:bg-red-50 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </UserLayout>
</template>
