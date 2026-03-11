<script setup>

</script>

<template>
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-indigo-100/50 blur-3xl"></div>
        <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] rounded-full bg-blue-100/50 blur-3xl"></div>
    </div>

    <div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">

        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="flex justify-center">
                <div
                    class="h-12 w-12 rounded-xl bg-primary flex items-center justify-center shadow-lg shadow-indigo-200">
                    <span class="text-white text-2xl font-bold">Q</span>
                </div>
            </div>
            <h1 class="mt-6 text-center text-2xl font-extrabold tracking-tight text-gray-900">
                Question System
            </h1>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div
                class="bg-white py-10 px-6 shadow-xl shadow-slate-200/50 sm:rounded-2xl sm:px-10 border border-gray-100">
                <slot>

                </slot>
            </div>
            <!-- 
            <p class="mt-10 text-center text-xs text-gray-400">
                &copy; {{ Date}} Question System. All rights reserved.
            </p> -->
        </div>
    </div>

</template>