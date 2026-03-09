<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Auth') | Question System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#059669', // Emerald 600
                        primaryDark: '#047857', // Emerald 700
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>

<body class="h-full bg-slate-50">

    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-indigo-100/50 blur-3xl"></div>
        <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] rounded-full bg-blue-100/50 blur-3xl"></div>
    </div>

    <div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="flex justify-center">
                <div class="h-12 w-12 rounded-xl bg-primary flex items-center justify-center shadow-lg shadow-indigo-200">
                    <span class="text-white text-2xl font-bold">Q</span>
                </div>
            </div>
            <h1 class="mt-6 text-center text-2xl font-extrabold tracking-tight text-gray-900">
                Question System
            </h1>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-10 px-6 shadow-xl shadow-slate-200/50 sm:rounded-2xl sm:px-10 border border-gray-100">
                @yield('content')
            </div>
            
            <p class="mt-10 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} Question System. All rights reserved.
            </p>
        </div>
    </div>

</body>

</html>