<!DOCTYPE html>
<html lang="en" class="h-full bg-[#f8fafc]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | Question System</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#059669', // Emerald 600
                        primaryDark: '#047857', // Emerald 700
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
</head>

<body class="h-full antialiased text-slate-900 flex flex-col">

    @include('partials.header')

    <main class="flex-grow py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

    <footer class="py-10 bg-white border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2">
                <div class="h-6 w-6 rounded bg-primary flex items-center justify-center">
                    <span class="text-white text-[10px] font-bold">Q</span>
                </div>
                <span class="text-sm font-bold text-slate-800 tracking-tight">Questly</span>
            </div>
            <p class="text-xs font-medium text-slate-400">
                &copy; {{ date('Y') }} — Engineered for explorers.
            </p>
        </div>
    </footer>

</body>
</html>