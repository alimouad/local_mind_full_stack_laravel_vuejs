@extends('layouts.userLayout') 

@section('title', 'Browse Questions')

@section('content')
<div class="max-w-5xl mx-auto px-4">

    @if(session('success'))
    <div
        x-data="{ show: true }"
        x-show="show"
        x-init="setTimeout(() => show = false, 4000)"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-800 text-sm font-bold flex items-center gap-3 shadow-sm"
    >
        <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div>
            <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">Community Feed</h1>
            <p class="text-slate-500 mt-2 text-lg font-medium">Insights and questions from the field.</p>
        </div>
        <a href="{{ route('questions.create') }}"
            class="inline-flex items-center justify-center px-6 py-3.5 bg-primary hover:bg-primaryDark text-white font-bold rounded-2xl shadow-lg shadow-emerald-200 transition-all active:scale-[0.98] gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
            </svg>
            Ask a Question
        </a>
    </div>

    <div class="bg-white p-2 rounded-2xl border border-slate-200/60 shadow-sm mb-8 flex flex-col md:flex-row gap-2">
        <div class="relative flex-grow">
            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input type="text" placeholder="Search by title or keywords..." class="w-full pl-12 pr-4 py-3 bg-transparent border-none focus:ring-0 text-slate-700 placeholder-slate-400 text-sm outline-none">
        </div>
        <div class="h-10 w-px bg-slate-100 hidden md:block self-center"></div>
        <select class="bg-transparent border-none text-slate-600 font-bold text-sm rounded-xl px-4 py-3 outline-none focus:ring-0 cursor-pointer">
            <option>Newest First</option>
            <option>Nearest to Me</option>
            <option>Trending</option>
        </select>
    </div>

    <div class="grid gap-5">
        @forelse($questions as $question)
        <div class="group bg-white p-1 rounded-3xl border border-slate-200/60 shadow-sm hover:shadow-xl hover:shadow-emerald-900/5 hover:border-emerald-200/50 transition-all duration-300">
            <div class="p-5 flex flex-col md:flex-row gap-6">
                
                <div class="hidden md:flex flex-col items-center justify-center min-w-[90px] h-[90px] rounded-2xl bg-slate-50 border border-slate-100 group-hover:bg-emerald-50 group-hover:border-emerald-100 transition-colors">
                    <span class="text-2xl font-black text-slate-800 group-hover:text-emerald-700">0</span>
                    <span class="text-[10px] uppercase tracking-widest font-extrabold text-slate-400 group-hover:text-emerald-600/70">Answers</span>
                </div>

                <div class="flex-grow flex flex-col">
                    <div class="flex items-center gap-3 mb-3">
                        @if($question->location)
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-[11px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-100/50">
                            <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" /></svg>
                            {{ $question->location }}
                        </span>
                        @endif
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-tight">{{ $question->created_at->diffForHumans() }}</span>
                    </div>

                    <a href="{{ route('question.view', $question->id) }}" class="group/title">
                        <h2 class="text-xl font-bold text-slate-900 mb-2 leading-tight group-hover/title:text-primary transition-colors flex items-center gap-2">
                            {{ $question->title }}
                            <svg class="w-5 h-5 opacity-0 -translate-x-2 group-hover/title:opacity-100 group-hover/title:translate-x-0 transition-all text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </h2>
                    </a>

                    <p class="text-slate-500 text-sm leading-relaxed line-clamp-2 mb-5">
                        {{ $question->content }}
                    </p>

                    <div class="mt-auto pt-4 border-t border-slate-50 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="relative">
                                <img src="https://ui-avatars.com/api/?name={{ $question->user->name ?? 'U' }}&background=059669&color=fff" class="w-7 h-7 rounded-lg shadow-sm">
                                <div class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-500 border-2 border-white rounded-full"></div>
                            </div>
                            <span class="text-xs font-bold text-slate-700">{{ $question->user->name ?? 'Anonymous' }}</span>
                        </div>

                        <div class="flex md:hidden items-center text-[11px] font-bold text-slate-400 uppercase">
                            0 Answers
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        @endforelse
    </div>

    <div class="mt-12">
        {{-- {{ $questions->links() }} --}}
    </div>
</div>
@endsection