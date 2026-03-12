<script setup>
import { computed, onMounted, ref } from 'vue';
import { RouterLink } from 'vue-router';
import axiosClient from '@/axios.js';
import AdminLayout from '@/layouts/AdminLayout.vue';

const loading = ref(true);
const deletingId = ref(null);
const errorMessage = ref('');
const search = ref('');
const answers = ref([]);

const filteredAnswers = computed(() => {
    const term = search.value.trim().toLowerCase();

    if (!term) {
        return answers.value;
    }

    return answers.value.filter((answer) => {
        return [answer.content, answer.user?.name, answer.user?.email, answer.question?.title]
            .filter(Boolean)
            .some((value) => value.toLowerCase().includes(term));
    });
});

function formatDate(value) {
    if (!value) return 'Unknown';
    return new Date(value).toLocaleString();
}

async function loadAnswers() {
    loading.value = true;
    errorMessage.value = '';

    try {
        const response = await axiosClient.get('/admin/answers');
        answers.value = response.data.data ?? [];
    } catch (error) {
        errorMessage.value = error.response?.data?.message ?? 'Failed to load answers.';
    } finally {
        loading.value = false;
    }
}

async function deleteAnswer(id) {
    if (!window.confirm('Delete this answer?')) {
        return;
    }

    deletingId.value = id;

    try {
        await axiosClient.delete(`/admin/answers/${id}`);
        answers.value = answers.value.filter((answer) => answer.id !== id);
    } catch (error) {
        errorMessage.value = error.response?.data?.message ?? 'Failed to delete answer.';
    } finally {
        deletingId.value = null;
    }
}

onMounted(loadAnswers);
</script>

<template>
    <AdminLayout>
        <section class="space-y-8">
            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
                <div>
                    <p class="text-[11px] font-black uppercase tracking-[0.25em] text-blue-500">Admin Answers</p>
                    <h1 class="text-4xl font-black text-slate-900 tracking-tight mt-2">Answer review</h1>
                    <p class="text-slate-500 font-medium mt-3">Inspect replies, trace them to their questions, and remove low-quality content.</p>
                </div>

                <input
                    v-model="search"
                    type="text"
                    placeholder="Search answers..."
                    class="w-full lg:w-80 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 shadow-sm outline-none focus:border-blue-300"
                />
            </div>

            <div v-if="loading" class="rounded-[2rem] border border-slate-200 bg-white p-10 text-center text-slate-500 shadow-sm">
                Loading answers...
            </div>

            <div v-else-if="errorMessage" class="rounded-[2rem] border border-red-200 bg-red-50 p-10 text-center text-red-700 shadow-sm">
                {{ errorMessage }}
            </div>

            <div v-else class="grid gap-4">
                <article v-for="answer in filteredAnswers" :key="answer.id" class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-lg shadow-slate-200/20">
                    <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-6">
                        <div class="space-y-4 flex-1 min-w-0">
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Replying To</p>
                                <p class="text-lg font-black text-slate-900 mt-1">{{ answer.question?.title || 'Deleted question' }}</p>
                            </div>

                            <p class="text-sm leading-7 text-slate-600">{{ answer.content }}</p>

                            <div class="flex flex-wrap items-center gap-4 text-xs font-semibold text-slate-500">
                                <span>{{ answer.user?.name || 'Unknown user' }}</span>
                                <span>{{ answer.user?.email || 'No email' }}</span>
                                <span>{{ formatDate(answer.created_at) }}</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <RouterLink
                                v-if="answer.question?.id"
                                :to="`/question/${answer.question.id}`"
                                class="px-4 py-2 rounded-xl bg-slate-100 text-xs font-black uppercase tracking-[0.12em] text-slate-600 hover:bg-slate-200"
                            >
                                View Question
                            </RouterLink>
                            <button
                                type="button"
                                @click="deleteAnswer(answer.id)"
                                :disabled="deletingId === answer.id"
                                class="px-4 py-2 rounded-xl bg-rose-50 text-xs font-black uppercase tracking-[0.12em] text-rose-600 hover:bg-rose-100 disabled:opacity-50"
                            >
                                {{ deletingId === answer.id ? 'Deleting...' : 'Delete' }}
                            </button>
                        </div>
                    </div>
                </article>

                <div v-if="filteredAnswers.length === 0" class="rounded-[2rem] border border-slate-200 bg-white p-10 text-center text-slate-400 shadow-sm">
                    No answers matched your search.
                </div>
            </div>
        </section>
    </AdminLayout>
</template>