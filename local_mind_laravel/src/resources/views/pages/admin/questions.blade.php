@extends('layouts.adminLayout')

@section('title', 'Dashboard Overview')

@section('content')
<div class="space-y-8">
    @if(session('success'))
    <div
        x-data="{ show: true }"
        x-show="show"
        x-init="setTimeout(() => show = false, 4000)"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-800 text-sm font-bold flex items-center gap-3 shadow-sm">
        <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
        {{ session('success') }}
    </div>
    @endif
    {{-- Page Header: Outside the card for better spacing --}}
    <header class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <nav class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3">
                <a href="/admin/dashboard" class="hover:text-primary transition-colors">Admin</a>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span class="text-slate-900">Questions</span>
            </nav>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight leading-none">
                Active <span class="text-student  bg-clip-text bg-primary ">Question</span>
            </h1>
            <p class="text-slate-400 font-medium mt-2">Manage student question groups and activity</p>
        </div>

    </header>

    {{-- Table Card Container --}}
    <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/30 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Author</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Title</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Location</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Answers</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Created</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($questions as $question)
                    <tr class="group hover:bg-emerald-50/20 transition-all duration-200">
                        {{-- Author --}}
                        <td class="px-10 py-5">
                            <div class="flex items-center gap-3">
                                <div class="relative flex-shrink-0">
                                    <img src="https://ui-avatars.com/api/?name={{ $question->user->name ?? 'U' }}&background=059669&color=fff" class="w-10 h-10 rounded-xl shadow-sm border-2 border-white">
                                    <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-emerald-500 border-2 border-white rounded-full"></div>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-700">{{ $question->user->name ?? 'Anonymous' }}</span>
                                    <span class="text-[9px] font-bold text-slate-400 uppercase">Student</span>
                                </div>
                            </div>
                        </td>

                        {{-- Title --}}
                        <td class="px-10 py-5">
                            <a href="{{ route('question.view', $question->id) }}" class="block group/link max-w-xs">
                                <span class="text-sm font-bold text-slate-900 truncate block group-hover/link:text-primary transition-colors">
                                    {{ $question->title }}
                                </span>
                                <span class="text-[10px] text-slate-400 font-medium truncate block italic opacity-70">
                                    {{ $question->content }}
                                </span>
                            </a>
                        </td>

                        {{-- Location --}}
                        <td class="px-10 py-5">
                            @if($question->location)
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-100/50">
                                <span class="material-symbols-outlined text-[12px] mr-1">location_on</span>
                                {{ $question->location }}
                            </span>
                            @else
                            <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">Remote</span>
                            @endif
                        </td>

                        {{-- Answers --}}
                        <td class="px-10 py-5">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center border border-slate-100">
                                    <span class="text-xs font-black text-slate-700">{{ $question->answers_count ?? 0 }}</span>
                                </div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Replies</span>
                            </div>
                        </td>

                        {{-- Created --}}
                        <td class="px-10 py-5">
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-slate-500 uppercase">{{ $question->created_at->diffForHumans() }}</span>
                                <span class="text-[9px] text-slate-300">{{ $question->created_at->format('d M Y') }}</span>
                            </div>
                        </td>

                        {{-- Actions --}}
                        <td class="px-10 py-5 text-right">
                            <div class="flex justify-end gap-1 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-x-2 group-hover:translate-x-0">
                                <a href="{{ route('question.view', $question->id) }}" class="p-2.5 text-slate-400 hover:text-primary hover:bg-emerald-50 rounded-xl transition-all">
                                    <span class="material-symbols-outlined text-xl">visibility</span>
                                </a>
                            </div>
                            <form action="{{route('admin.delete.question',$question->id)}}" method="post" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this answer?')" class="p-2.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all">
                                    <span class="material-symbols-outlined text-xl">delete</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-10 py-32 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 mb-4">
                                    <span class="material-symbols-outlined text-4xl">inventory_2</span>
                                </div>
                                <p class="text-slate-400 font-bold uppercase tracking-widest text-xs">No active questions found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection