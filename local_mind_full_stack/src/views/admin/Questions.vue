<script setup>
import { computed, onMounted, ref } from 'vue';
import { RouterLink } from 'vue-router';
import axiosClient from '@/axios.js';
import AdminLayout from '@/layouts/AdminLayout.vue';

const loading = ref(true);
const deletingId = ref(null);
const errorMessage = ref('');
const search = ref('');
const questions = ref([]);

const filteredQuestions = computed(() => {
    const term = search.value.trim().toLowerCase();

    if (!term) {
        return questions.value;
    }

    return questions.value.filter((question) => {
        return [question.title, question.content, question.location, question.user?.name, question.user?.email]
            .filter(Boolean)
            .some((value) => value.toLowerCase().includes(term));
    });
});

function formatDate(value) {
    if (!value) return 'Unknown';
    return new Date(value).toLocaleString();
}

function avatarUrl(name) {
    return `https://ui-avatars.com/api/?name=${encodeURIComponent(name || 'User')}&background=ecfdf5&color=047857`;
}

async function loadQuestions() {
    loading.value = true;
    errorMessage.value = '';

    try {
        const response = await axiosClient.get('/admin/questions');
        questions.value = response.data.data ?? [];
    } catch (error) {
        errorMessage.value = error.response?.data?.message ?? 'Failed to load questions.';
    } finally {
        loading.value = false;
    }
}

async function deleteQuestion(id) {
    if (!window.confirm('Delete this question?')) {
        return;
    }

    deletingId.value = id;

    try {
        await axiosClient.delete(`/admin/questions/${id}`);
        questions.value = questions.value.filter((question) => question.id !== id);
    } catch (error) {
        errorMessage.value = error.response?.data?.message ?? 'Failed to delete question.';
    } finally {
        deletingId.value = null;
    }
}

onMounted(loadQuestions);
</script>

<template>
    <AdminLayout>
        <section class="space-y-8">
            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
                <div>
                    <p class="text-[11px] font-black uppercase tracking-[0.25em] text-emerald-500">Admin Questions</p>
                    <h1 class="text-4xl font-black text-slate-900 tracking-tight mt-2">Question moderation</h1>
                    <p class="text-slate-500 font-medium mt-3">Review, inspect, and remove community questions from one place.</p>
                </div>

                <div class="flex items-center gap-3">
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Search questions..."
                        class="w-full lg:w-80 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 shadow-sm outline-none focus:border-emerald-300"
                    />
                    <RouterLink
                        to="/admin/home"
                        class="px-5 py-3 rounded-2xl bg-slate-900 text-white text-xs font-black uppercase tracking-[0.15em]"
                    >
                        Dashboard
                    </RouterLink>
                </div>
            </div>

            <div v-if="loading" class="rounded-[2rem] border border-slate-200 bg-white p-10 text-center text-slate-500 shadow-sm">
                Loading questions...
            </div>

            <div v-else-if="errorMessage" class="rounded-[2rem] border border-red-200 bg-red-50 p-10 text-center text-red-700 shadow-sm">
                {{ errorMessage }}
            </div>

            <div v-else class="rounded-[2rem] border border-slate-200 bg-white shadow-xl shadow-slate-200/30 overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-black text-slate-900">All Questions</h2>
                        <p class="text-xs font-bold uppercase tracking-[0.15em] text-slate-400 mt-1">{{ filteredQuestions.length }} results</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/70 border-b border-slate-100">
                                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Author</th>
                                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Question</th>
                                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Stats</th>
                                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Created</th>
                                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody v-if="filteredQuestions.length" class="divide-y divide-slate-100">
                            <tr v-for="question in filteredQuestions" :key="question.id" class="hover:bg-slate-50/70 transition-colors">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        <img :src="avatarUrl(question.user?.name)" class="w-10 h-10 rounded-xl border border-slate-100" />
                                        <div>
                                            <p class="text-sm font-bold text-slate-900">{{ question.user?.name || 'Unknown' }}</p>
                                            <p class="text-xs text-slate-400">{{ question.user?.email || 'No email' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5 min-w-[360px]">
                                    <p class="text-sm font-bold text-slate-900">{{ question.title }}</p>
                                    <p class="text-sm text-slate-500 mt-1 line-clamp-2">{{ question.content }}</p>
                                    <p class="text-xs font-semibold text-emerald-600 mt-2">{{ question.location || 'Unknown location' }}</p>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="inline-flex rounded-full bg-emerald-50 px-3 py-1 text-xs font-black text-emerald-700">
                                        {{ question.answers_count }} answers
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-sm text-slate-500">{{ formatDate(question.created_at) }}</td>
                                <td class="px-8 py-5">
                                    <div class="flex justify-end gap-2">
                                        <RouterLink :to="`/question/${question.id}`" class="px-4 py-2 rounded-xl bg-slate-100 text-xs font-black uppercase tracking-[0.12em] text-slate-600 hover:bg-slate-200">
                                            View
                                        </RouterLink>
                                        <button
                                            type="button"
                                            @click="deleteQuestion(question.id)"
                                            :disabled="deletingId === question.id"
                                            class="px-4 py-2 rounded-xl bg-rose-50 text-xs font-black uppercase tracking-[0.12em] text-rose-600 hover:bg-rose-100 disabled:opacity-50"
                                        >
                                            {{ deletingId === question.id ? 'Deleting...' : 'Delete' }}
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center text-slate-400 font-medium">No questions matched your search.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </AdminLayout>
</template>