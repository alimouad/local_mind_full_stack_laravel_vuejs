@extends('layouts.adminLayout')

@section('title', 'System Overview')

@section('content')
<div class="space-y-8">
    {{-- 1. Performance Metric Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        <div class="group relative bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/30 hover:shadow-emerald-500/10 hover:-translate-y-1.5 transition-all duration-500 overflow-hidden">
            {{-- Decorative Background Glow --}}
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-50 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

            <div class="relative z-10">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 group-hover:from-emerald-500 group-hover:to-emerald-600 group-hover:text-white group-hover:rotate-6 transition-all duration-500 shadow-sm">
                        <span class="material-symbols-outlined text-3xl">quiz</span>
                    </div>
                    <div class="flex flex-col items-end">
                        <div class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black rounded-full uppercase tracking-widest border border-emerald-100 group-hover:bg-emerald-500 group-hover:text-white group-hover:border-transparent transition-all">Live</div>
                        <span class="text-[10px] font-bold text-emerald-500 mt-2 flex items-center">
                            <span class="material-symbols-outlined text-xs mr-1">trending_up</span> +12%
                        </span>
                    </div>
                </div>

                <div class="space-y-1">
                    <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-[0.25em]">Global Queries</p>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-4xl font-black text-slate-900 tracking-tight">{{ number_format($totalQuestions) }}</h3>
                        <span class="text-xs font-bold text-slate-300">Total</span>
                    </div>
                </div>

                {{-- Mini Sparkline Visualization --}}
                <div class="mt-6 h-1 w-full bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-emerald-500 w-2/3 group-hover:w-full transition-all duration-1000 ease-out"></div>
                </div>
            </div>
        </div>

        <div class="group relative bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/30 hover:shadow-blue-500/10 hover:-translate-y-1.5 transition-all duration-500 overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-50 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

            <div class="relative z-10">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl flex items-center justify-center text-blue-600 group-hover:from-blue-500 group-hover:to-blue-600 group-hover:text-white group-hover:-rotate-6 transition-all duration-500 shadow-sm">
                        <span class="material-symbols-outlined text-3xl">forum</span>
                    </div>
                    <div class="flex flex-col items-end">
                        <div class="px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-black rounded-full uppercase tracking-widest border border-blue-100 group-hover:bg-blue-500 group-hover:text-white group-hover:border-transparent transition-all">Active</div>
                        <span class="text-[10px] font-bold text-blue-400 mt-2">89.4% Rate</span>
                    </div>
                </div>

                <div class="space-y-1">
                    <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-[0.25em]">Community Help</p>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-4xl font-black text-slate-900 tracking-tight">{{ number_format($totalAnswers) }}</h3>
                        <span class="text-xs font-bold text-slate-300">Replies</span>
                    </div>
                </div>

                <div class="mt-6 h-1 w-full bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-blue-500 w-1/2 group-hover:w-[89%] transition-all duration-1000 ease-out"></div>
                </div>
            </div>
        </div>

        <div class="group relative bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/30 hover:shadow-pink-500/10 hover:-translate-y-1.5 transition-all duration-500 overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-pink-50 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

            <div class="relative z-10">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-pink-50 to-pink-100 rounded-2xl flex items-center justify-center text-pink-600 group-hover:from-pink-500 group-hover:to-pink-600 group-hover:text-white group-hover:scale-110 transition-all duration-500 shadow-sm">
                        <span class="material-symbols-outlined text-3xl">person_add</span>
                    </div>
                    <div class="flex flex-col items-end">
                        <div class="px-3 py-1 bg-pink-50 text-pink-600 text-[10px] font-black rounded-full uppercase tracking-widest border border-pink-100 group-hover:bg-pink-500 group-hover:text-white group-hover:border-transparent transition-all">+7 Days</div>
                        <span class="text-[10px] font-bold text-pink-400 mt-2 flex items-center">
                            <span class="material-symbols-outlined text-xs mr-1">history</span> Recent
                        </span>
                    </div>
                </div>

                <div class="space-y-1">
                    <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-[0.25em]">New Students</p>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-4xl font-black text-slate-900 tracking-tight">{{ $newUsers }}</h3>
                        <span class="text-xs font-bold text-slate-300">Joined</span>
                    </div>
                </div>

                <div class="mt-6 h-1 w-full bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-pink-500 w-1/4 group-hover:w-3/4 transition-all duration-1000 ease-out"></div>
                </div>
            </div>
        </div>
    </div>
    {{-- 2. Recent Activity & Management --}}
    <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/30 overflow-hidden">
        <div class="px-10 py-8 border-b border-slate-100 flex items-center justify-between bg-slate-50/30">
            <div>
                <h3 class="text-xl font-black text-slate-900 tracking-tight">Recent Activity</h3>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Questions from the last 24 hours</p>
            </div>
            <a href="{{ route('admin.users') }}" class="px-6 py-3 bg-white border border-slate-200 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-50 transition-all">Manage All</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-10 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Author</th>
                        <th class="px-10 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Title</th>
                        <th class="px-10 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Post Time</th>
                        <th class="px-10 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentQuestions as $question)
                    <tr class="group hover:bg-emerald-50/20 transition-all duration-200">
                        <td class="px-10 py-5">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($question->user->name) }}&background=f1f5f9&color=64748b" class="w-9 h-9 rounded-xl border border-slate-100">
                                <span class="text-sm font-bold text-slate-700">{{ $question->user->name }}</span>
                            </div>
                        </td>
                        <td class="px-10 py-5">
                            <span class="text-sm font-bold text-slate-900 line-clamp-1 group-hover:text-primary transition-colors">
                                {{ $question->title }}
                            </span>
                        </td>
                        <td class="px-10 py-5">
                            <span class="text-xs font-bold text-slate-400 uppercase">{{ $question->created_at->diffForHumans() }}</span>
                        </td>
                        <td class="px-10 py-5 text-right">
                            <a href="{{ route('question.view', $question->id) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-widest hover:bg-primary hover:text-white transition-all">
                                View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-10 py-20 text-center">
                            <p class="text-slate-400 font-medium italic">No new activity in the last 24 hours.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection