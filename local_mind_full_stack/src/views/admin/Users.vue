<script setup>
import { computed, onMounted, ref } from 'vue';
import axiosClient from '@/axios.js';
import AdminLayout from '@/layouts/AdminLayout.vue';

const loading = ref(true);
const deletingId = ref(null);
const errorMessage = ref('');
const search = ref('');
const users = ref([]);

const filteredUsers = computed(() => {
    const term = search.value.trim().toLowerCase();

    if (!term) {
        return users.value;
    }

    return users.value.filter((user) => {
        return [user.name, user.email, user.role]
            .filter(Boolean)
            .some((value) => value.toLowerCase().includes(term));
    });
});

function formatDate(value) {
    if (!value) return 'Unknown';
    return new Date(value).toLocaleDateString();
}

function avatarUrl(name) {
    return `https://ui-avatars.com/api/?name=${encodeURIComponent(name || 'User')}&background=eff6ff&color=1d4ed8`;
}

async function loadUsers() {
    loading.value = true;
    errorMessage.value = '';

    try {
        const response = await axiosClient.get('/admin/users');
        users.value = response.data.data ?? [];
    } catch (error) {
        errorMessage.value = error.response?.data?.message ?? 'Failed to load users.';
    } finally {
        loading.value = false;
    }
}

async function deleteUser(id) {
    if (!window.confirm('Delete this user?')) {
        return;
    }

    deletingId.value = id;

    try {
        await axiosClient.delete(`/admin/users/${id}`);
        users.value = users.value.filter((user) => user.id !== id);
    } catch (error) {
        errorMessage.value = error.response?.data?.message ?? 'Failed to delete user.';
    } finally {
        deletingId.value = null;
    }
}

onMounted(loadUsers);
</script>

<template>
    <AdminLayout>
        <section class="space-y-8">
            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
                <div>
                    <p class="text-[11px] font-black uppercase tracking-[0.25em] text-indigo-500">Admin Users</p>
                    <h1 class="text-4xl font-black text-slate-900 tracking-tight mt-2">User access and activity</h1>
                    <p class="text-slate-500 font-medium mt-3">Track account roles, contribution volume, and remove accounts when needed.</p>
                </div>

                <input
                    v-model="search"
                    type="text"
                    placeholder="Search users..."
                    class="w-full lg:w-80 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 shadow-sm outline-none focus:border-indigo-300"
                />
            </div>

            <div v-if="loading" class="rounded-[2rem] border border-slate-200 bg-white p-10 text-center text-slate-500 shadow-sm">
                Loading users...
            </div>

            <div v-else-if="errorMessage" class="rounded-[2rem] border border-red-200 bg-red-50 p-10 text-center text-red-700 shadow-sm">
                {{ errorMessage }}
            </div>

            <div v-else class="rounded-[2rem] border border-slate-200 bg-white shadow-xl shadow-slate-200/30 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/70 border-b border-slate-100">
                                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Profile</th>
                                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Role</th>
                                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Contributions</th>
                                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Joined</th>
                                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody v-if="filteredUsers.length" class="divide-y divide-slate-100">
                            <tr v-for="user in filteredUsers" :key="user.id" class="hover:bg-slate-50/70 transition-colors">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        <img :src="avatarUrl(user.name)" class="w-11 h-11 rounded-xl border border-slate-100" />
                                        <div>
                                            <p class="text-sm font-bold text-slate-900">{{ user.name }}</p>
                                            <p class="text-xs text-slate-400">{{ user.email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-black"
                                        :class="user.role === 'ADMIN' ? 'bg-slate-900 text-white' : 'bg-indigo-50 text-indigo-700'">
                                        {{ user.role }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-sm text-slate-600">
                                    <span class="font-bold text-slate-900">{{ user.questions_count }}</span> questions
                                    <span class="mx-2 text-slate-300">/</span>
                                    <span class="font-bold text-slate-900">{{ user.answers_count }}</span> answers
                                </td>
                                <td class="px-8 py-5 text-sm text-slate-500">{{ formatDate(user.created_at) }}</td>
                                <td class="px-8 py-5 text-right">
                                    <button
                                        type="button"
                                        @click="deleteUser(user.id)"
                                        :disabled="deletingId === user.id || user.role === 'ADMIN'"
                                        class="px-4 py-2 rounded-xl bg-rose-50 text-xs font-black uppercase tracking-[0.12em] text-rose-600 hover:bg-rose-100 disabled:opacity-50"
                                    >
                                        {{ deletingId === user.id ? 'Deleting...' : 'Delete' }}
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center text-slate-400 font-medium">No users matched your search.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </AdminLayout>
</template>