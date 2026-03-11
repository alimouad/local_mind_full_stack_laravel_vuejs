<script setup>
import GuestLayout from '@/layouts/GuestLayout.vue';
import { ref } from 'vue';
import axiosClient from '@/axios.js';
import { useRouter } from 'vue-router';

const router = useRouter();
const success = ref('');

const data = ref({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const errors = ref({
    name: [],
    email: [],
    password: [],
});

function submit() {
    errors.value = { name: [], email: [], password: [] };
    axiosClient.post('/register', data.value)
        .then(response => {
            success.value = 'Account created successfully!';
            data.value = {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
            };
        })
        .catch(error => {
            if (error.response?.data?.errors) {
                errors.value = error.response.data.errors;
            }
        });
}
</script>

<template>
    <GuestLayout>
        <div class="w-full max-w-md mx-auto">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Join us</h2>
                <p class="text-sm text-gray-500 mt-2">Create your account to get started.</p>
            </div>
            <div v-if="success" class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 text-sm font-medium">
                {{ success }}
            </div>

            <form @submit.prevent="submit" class="space-y-5" novalidate>

                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700">Full Name</label>
                    <div class="mt-1">
                        <input id="name" type="text" v-model="data.name" name="name" value="{{ old('name') }}" required
                            autofocus placeholder="John Doe"
                            class="block w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:ring-2 focus:ring-primary focus:border-primary border transition-all duration-200 outline-none @error('name') border-red-500 @enderror">
                    </div>
                    <p class="text-sm mt-1 text-red-600">
                        {{ errors.name ? errors.name[0] : '' }}
                    </p>
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700">Email Address</label>
                    <div class="mt-1">
                        <input id="email" type="email" v-model="data.email" name="email" value="{{ old('email') }}"
                            required placeholder="name@company.com"
                            class="block w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:ring-2 focus:ring-primary focus:border-primary border transition-all duration-200 outline-none @error('email') border-red-500 @enderror">
                    </div>
                    <p class="text-sm mt-1 text-red-600">
                        {{ errors.email ? errors.email[0] : '' }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                        <div class="mt-1">
                            <input id="password" type="password" v-model="data.password" name="password" required
                                placeholder="••••••••"
                                class="block w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:ring-2 focus:ring-primary focus:border-primary border transition-all duration-200 outline-none @error('password') border-red-500 @enderror">
                        </div>
                        <p class="text-sm mt-1 text-red-600">
                            {{ errors.password ? errors.password[0] : '' }}
                        </p>
                    </div>

                    <div>
                        <label for="password_confirmation"
                            class="block text-sm font-semibold text-gray-700">Confirm</label>
                        <div class="mt-1">
                            <input id="password_confirmation" type="password" v-model="data.password_confirmation"
                                name="password_confirmation" required placeholder="••••••••"
                                class="block w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:ring-2 focus:ring-primary focus:border-primary border transition-all duration-200 outline-none">
                        </div>
                    </div>
                </div>


                <div class="pt-2">
                    <button type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-primary hover:bg-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all duration-150 active:scale-[0.98] shadow-lg shadow-indigo-200">
                        Create account
                    </button>
                </div>

                <p class="text-center text-sm text-gray-500 pt-4">
                    Already have an account?
                    <RouterLink to="/login" class="font-bold text-primary hover:text-primary transition-colors">
                        Sign in
                    </RouterLink>
                </p>
            </form>
        </div>
    </GuestLayout>
</template>