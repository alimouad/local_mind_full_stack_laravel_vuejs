<script setup>
import { computed, onMounted, ref } from 'vue';
import { RouterLink, useRoute, useRouter } from 'vue-router';
import UserLayout from '@/layouts/UserLayout.vue';
import axiosClient from '@/axios.js';

const route = useRoute();
const router = useRouter();

const question = ref(null);
const loading = ref(true);
const errorMessage = ref('');
const answerForm = ref({ content: '' });
const answerErrors = ref({});
const answerSuccess = ref('');
const success = ref('');
const submittingAnswer = ref(false);

const answers = computed(() => question.value?.answers ?? []);

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

function avatarUrl(name) {
    return `https://ui-avatars.com/api/?name=${encodeURIComponent(name ?? 'U')}&background=059669&color=fff`;
}

async function loadQuestion() {
    loading.value = true;
    errorMessage.value = '';

    try {
        const response = await axiosClient.get(`/questions/${route.params.id}`);
        question.value = response.data;
    } catch (error) {
        errorMessage.value = error.response?.data?.message ?? 'Failed to load question.';
    } finally {
        loading.value = false;
    }
}

async function toggleFav() {
    if (!question.value) return;
    try {
        const response = await axiosClient.post(`/questions/${question.value.id}/favourite`);
        question.value.is_favourited = response.data.is_favourited;
    } catch (e) {
        // silent
    }
}

async function deleteQuestion() {
    if (!confirm('Delete this question? This cannot be undone.')) return;
    try {
        await axiosClient.delete(`/questions/${question.value.id}`);
        router.push({ name: 'home' });

    } catch (e) {
        errorMessage.value = e.response?.data?.message ?? 'Failed to delete question.';
    }
}

async function deleteAnswer(answer) {
    if (!confirm('Delete this answer?')) return;
    try {
        await axiosClient.delete(`/answers/${answer.id}`);
        question.value.answers = question.value.answers.filter(a => a.id !== answer.id);
        
    } catch (e) {
        // silent
    }
    finally {
        success.value = response.data.message ?? 'Answer deleted successfully!';
    }
}

async function submitAnswer() {
    answerErrors.value = {};
    answerSuccess.value = '';
    submittingAnswer.value = true;

    try {
        const response = await axiosClient.post(`/questions/${route.params.id}/answers`, {
            content: answerForm.value.content,
        });

        if (!Array.isArray(question.value.answers)) {
            question.value.answers = [];
        }

        question.value.answers.unshift(response.data.answer);
        answerForm.value.content = '';
        answerSuccess.value = response.data.message ?? 'Answer posted successfully!';
    } catch (error) {
        if (error.response?.data?.errors) {
            answerErrors.value = error.response.data.errors;
        } else {
            answerErrors.value = {
                content: [error.response?.data?.message ?? 'Failed to post answer.'],
            };
        }
    } finally {
        submittingAnswer.value = false;
    }
}

onMounted(loadQuestion);
</script>

<template>
<UserLayout>
    <div class="max-w-4xl mx-auto px-4 py-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
        
        <header class="mb-8 flex items-center justify-between">
            <RouterLink to="/home"
                class="group flex items-center gap-2 px-4 py-2 rounded-full bg-white border border-slate-200 text-sm font-bold text-slate-600 hover:text-primary hover:border-primary/30 hover:shadow-md transition-all">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Feed
            </RouterLink>
             <transition name="fade">
                <div v-if="success" class="mt-6 p-4 rounded-2xl bg-emerald-500 text-white text-sm font-bold shadow-lg shadow-emerald-200 flex items-center gap-3 animate-in slide-in-from-top-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                    {{ success }}
                </div>
            </transition>
            
            <div v-if="question" class="flex items-center gap-2">
                <button @click="toggleFav"
                    :title="question.is_favourited ? 'Remove from favourites' : 'Add to favourites'"
                    class="p-2.5 rounded-full transition-all"
                    :class="question.is_favourited ? 'text-rose-500 bg-rose-50 hover:bg-rose-100' : 'text-slate-400 bg-slate-50 hover:text-rose-400 hover:bg-rose-50'">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" :fill="question.is_favourited ? 'currentColor' : 'none'" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </button>
                <button v-if="question.is_owner" @click="deleteQuestion"
                    title="Delete question"
                    class="p-2.5 rounded-full bg-slate-50 text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
                <button class="p-2.5 rounded-full bg-slate-50 text-slate-400 hover:text-primary hover:bg-primary/5 transition-all" title="Share">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 100-2.684 3 3 0 000 2.684zm0 9a3 3 0 100-2.684 3 3 0 000 2.684z" /></svg>
                </button>
            </div>
        </header>

        <div v-if="loading" class="flex flex-col items-center justify-center min-h-[400px] rounded-[2.5rem] bg-white border border-slate-100 shadow-sm">
            <div class="relative w-16 h-16">
                <div class="absolute inset-0 border-4 border-primary/10 rounded-full"></div>
                <div class="absolute inset-0 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
            </div>
            <p class="mt-4 text-slate-400 font-medium tracking-wide">Gathering context...</p>
        </div>

        <div v-else-if="errorMessage" class="rounded-[2.5rem] border border-red-100 bg-red-50/30 p-12 text-center">
            <div class="inline-flex p-4 rounded-2xl bg-white shadow-sm text-red-500 mb-6">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>
            <h3 class="text-xl font-black text-slate-900 mb-2">Something went wrong</h3>
            <p class="text-slate-600 mb-6">{{ errorMessage }}</p>
            <button @click="window.location.reload()" class="px-6 py-2 bg-slate-900 text-white rounded-full font-bold text-sm">Try Again</button>
        </div>

        <template v-else-if="question">
            <article class="bg-white rounded-[2.5rem] border border-slate-200/60 shadow-2xl shadow-slate-200/40 overflow-hidden ring-1 ring-black/[0.02]">
                <div class="p-8 md:p-12">
                    <div class="flex items-center gap-3 mb-8">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-[0.1em] bg-emerald-500 text-white">
                            <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse mr-2"></span>
                            Live Question
                        </span>
                        <span class="text-xs font-bold text-slate-400">
                            {{ formatRelativeDate(question.created_at) }}
                        </span>
                    </div>

                    <h1 class="text-3xl md:text-3xl font-black text-slate-900 leading-[1.15] mb-8 tracking-tight">
                        {{ question.title }}
                    </h1>

                    <div class="flex items-center gap-4 mb-10 pb-10 border-b border-slate-100">
                        <div class="relative group cursor-pointer">
                            <img :src="avatarUrl(question.user?.name)" class="w-14 h-14 rounded-2xl object-cover ring-4 ring-slate-50 transition-all group-hover:scale-105">
                            <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-blue-500 border-4 border-white rounded-full flex items-center justify-center">
                                <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.64.304 1.25.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" /></svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-lg font-bold text-slate-900 leading-none mb-1">{{ question.user?.name ?? 'Community Member' }}</p>
                            <p class="text-xs text-slate-400 font-bold tracking-widest uppercase">Verified Author</p>
                        </div>
                    </div>

                    <div class="prose prose-slate max-w-none">
                        <p class="text-xl text-slate-600 font-medium leading-relaxed whitespace-pre-line">
                            {{ question.content }}
                        </p>
                    </div>
                </div>

                <div class="bg-slate-50/50 backdrop-blur-md border-t border-slate-100 p-8 md:px-12">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8">
                        <div class="flex items-start gap-4">
                            <div class="mt-1 p-2 bg-white rounded-xl shadow-sm border border-slate-200 text-primary">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] mb-1">Incident Location</p>
                                <p class="text-slate-800 font-bold text-lg leading-tight">{{ question.location }}</p>
                            </div>
                        </div>
                        
                        <div class="flex gap-3">
                            <div class="bg-white/80 border border-slate-200 rounded-2xl px-5 py-3 shadow-sm">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">Latitude</p>
                                <code class="text-sm font-mono font-bold text-slate-700">{{ question.latitude }}</code>
                            </div>
                            <div class="bg-white/80 border border-slate-200 rounded-2xl px-5 py-3 shadow-sm">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">Longitude</p>
                                <code class="text-sm font-mono font-bold text-slate-700">{{ question.longitude }}</code>
                            </div>
                        </div>
                    </div>
                </div>
            </article>

            <transition name="fade">
                <div v-if="answerSuccess" class="mt-6 p-4 rounded-2xl bg-emerald-500 text-white text-sm font-bold shadow-lg shadow-emerald-200 flex items-center gap-3 animate-in slide-in-from-top-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                    {{ answerSuccess }}
                </div>
            </transition>

            <div v-if="answerErrors.content" class="mt-6 p-4 rounded-2xl bg-red-50 text-red-600 text-sm font-bold border border-red-100 flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                {{ answerErrors.content[0]}}
            </div>

            <section class="mt-16">
                <div class="flex items-center justify-between mb-10 px-4">
                    <h3 class="text-4xl font-black text-slate-900 tracking-tighter">
                        Discussion
                        <span class="ml-2 text-slate-300 font-medium">{{ answers.length }}</span>
                    </h3>
                </div>

                <div v-if="answers.length === 0" class="py-24 bg-slate-50/50 rounded-[2.5rem] border-2 border-dashed border-slate-200 flex flex-col items-center justify-center text-center">
                    <div class="w-20 h-20 bg-white rounded-3xl shadow-sm flex items-center justify-center mb-6">
                        <svg class="w-10 h-10 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">No responses yet</h3>
                    <p class="text-slate-500 max-w-xs mx-auto mt-2 font-medium leading-relaxed">Share your perspective and help the community grow.</p>
                </div>

                <div v-else class="space-y-6">
                    <div v-for="answer in answers" :key="answer.id"
                        class="group bg-white p-8 rounded-[2rem] border border-slate-200/60 shadow-sm hover:shadow-xl hover:shadow-slate-200/30 transition-all duration-500 hover:-translate-y-1">
                        <div class="flex items-start gap-5">
                            <img :src="avatarUrl(answer.user?.name)" class="w-12 h-12 rounded-2xl object-cover shadow-sm ring-2 ring-slate-50">
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-2">
                                        <span class="text-base font-black text-slate-900">{{ answer.user?.name ?? 'Anonymous User' }}</span>
                                        <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                        <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">{{ formatRelativeDate(answer.created_at) }}</span>
                                    </div>
                                    <button v-if="answer.is_owner" @click="deleteAnswer(answer)" title="Delete answer"
                                        class="p-1.5 rounded-lg text-slate-300 hover:text-red-500 hover:bg-red-50 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="text-slate-600 text-lg leading-relaxed font-medium">
                                    {{ answer.content }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-12 sticky bottom-8">
                    <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] border border-slate-200 shadow-2xl p-2 ring-1 ring-black/5">
                        <form @submit.prevent="submitAnswer" class="relative">
                            <textarea
                                v-model="answerForm.content"
                                rows="3"
                                required
                                placeholder="Write your response..."
                                class="w-full px-8 py-6 rounded-[2rem] bg-transparent border-none focus:ring-0 text-slate-800 placeholder-slate-400 text-lg resize-none"></textarea>
                            
                            <div class="flex items-center justify-between p-3 bg-slate-50/50 rounded-[1.8rem] border border-slate-100">
                                <div class="flex items-center gap-3 px-4 py-2">
                                    <span class="hidden md:block text-xs font-black text-slate-400 uppercase tracking-widest">Rules: Stay helpful</span>
                                </div>
                                <button
                                    type="submit"
                                    :disabled="submittingAnswer"
                                    class="inline-flex items-center justify-center px-10 py-4 bg-primary hover:bg-emerald-600 text-white font-black rounded-[1.5rem] shadow-xl shadow-emerald-200 transition-all active:scale-95 disabled:opacity-50 disabled:grayscale">
                                    <span>{{ submittingAnswer ? 'Posting...' : 'Post Response' }}</span>
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 5l7 7-7 7M5 5l7 7-7 7" /></svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </template>
    </div>
</UserLayout>
</template>