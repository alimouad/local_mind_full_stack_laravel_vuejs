<script setup>
import GuestLayout from '@/layouts/GuestLayout.vue';
import axiosClient from '@/axios.js';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const data = ref({
    email: '',
    password: '',
});
const errorMessage = ref('');

function submit() {
    errorMessage.value = '';
    axiosClient.post('/login', data.value)
        .then(response => {
            const user = response.data?.user;
            const role = user?.role ?? 'USER';

            if (user?.name) {
                localStorage.setItem('user_name', user.name);
            }

            localStorage.setItem('user_role', role);

            router.push({ name: role === 'ADMIN' ? 'admin-home' : 'home' });
        })
        .catch(error => {
            errorMessage.value = error.response?.data?.message ?? 'Login failed.';
        });
}
</script>

<template>
    <GuestLayout>
        <div class="w-full max-w-md mx-auto">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Welcome back</h2>
                <p class="text-sm text-gray-500 mt-2">Please enter your details to sign in.</p>
            </div>
            <div v-if="errorMessage" class="my-4 py-2 px-3 rounded text-white bg-red-400">
                {{ errorMessage }}
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700">Email Address</label>
                    <div class="mt-1 relative">
                        <input id="email" type="email" v-model="data.email" name="email" required autofocus
                            placeholder="name@company.com"
                            class="block w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:ring-2 focus:ring-primary focus:border-primary border transition-all duration-200 outline-none">
                    </div>

                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                        <a href="#" class="text-xs font-semibold text-primary hover:text-primary">Forgot password?</a>
                    </div>
                    <div class="mt-1 relative">
                        <input id="password" type="password" v-model="data.password" name="password" required placeholder="••••••••"
                            class="block w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:ring-2 focus:ring-primary focus:border-primary border transition-all duration-200 outline-none">
                    </div>

                </div>

                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox"
                        class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded cursor-pointer">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-600 cursor-pointer">Remember me</label>
                </div>



                <button type="submit"
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-primary hover:bg-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all duration-150 active:scale-[0.98] shadow-lg shadow-indigo-200">
                    Sign in
                </button>

                <p class="text-center text-sm text-gray-500 pt-4">
                    New here?
                    <RouterLink to="/register" class="font-bold text-primary hover:text-primary transition-colors">
                        Create an account
                    </RouterLink>
                </p>
            </form>
        </div>
    </GuestLayout>
</template>