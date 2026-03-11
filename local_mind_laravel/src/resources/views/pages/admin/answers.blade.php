@extends('layouts.adminLayout')

@section('title', 'Manage Answers')

@section('content')
<div class="space-y-8">
    {{-- Header Section --}}
    <header class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <nav class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3">
                <a href="/admin/dashboard" class="hover:text-primary transition-colors">Admin</a>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span class="text-slate-900">Answers</span>
            </nav>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight leading-none">
                Recent <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-teal-400">Responses</span>
            </h1>
            <p class="text-slate-400 font-medium mt-2">Monitor and moderate community discussions</p>
        </div>

        <div class="flex items-center gap-3">
            <div class="bg-white px-6 py-3 rounded-2xl border border-slate-200 flex items-center gap-4 shadow-sm">
                <div class="text-right">
                    <p class="text-[10px] font-black text-slate-400 uppercase leading-none">Total Answers</p>
                    <p class="text-xl font-black text-slate-900">{{ $answers->count() }}</p>
                </div>
                <div class="h-8 w-px bg-slate-100"></div>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <span class="material-symbols-outlined">forum</span>
                </div>
            </div>
        </div>
    </header>

    {{-- Table Card --}}
    <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/30 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Respondent</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Answer Snippet</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">On Question</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Posted</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($answers as $answer)
                    <tr class="group hover:bg-slate-50/50 transition-all duration-200">
                        {{-- User --}}
                        <td class="px-10 py-5">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ $answer->user->name }}&background=059669&color=fff" class="w-9 h-9 rounded-xl border border-slate-100 shadow-sm">
                                <div>
                                    <span class="text-sm font-bold text-slate-800 block">{{ $answer->user->name }}</span>
                                    <span class="text-[9px] font-bold text-emerald-500 uppercase">Member</span>
                                </div>
                            </div>
                        </td>

                        {{-- Content Snippet --}}
                        <td class="px-10 py-5">
                            <p class="text-sm text-slate-600 leading-relaxed max-w-sm line-clamp-2 italic">
                                "{{ $answer->content }}"
                            </p>
                        </td>

                        {{-- Parent Question --}}
                        <td class="px-10 py-5">
                            <a href="{{ route('question.view', $answer->question_id) }}" class="flex items-center gap-2 group/q">
                                <span class="text-xs font-bold text-slate-500 group-hover/q:text-primary transition-colors truncate max-w-[180px]">
                                    {{ $answer->question->title }}
                                </span>
                                <span class="material-symbols-outlined text-slate-300 text-sm">open_in_new</span>
                            </a>
                        </td>

                        {{-- Date --}}
                        <td class="px-10 py-5">
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-slate-600">{{ $answer->created_at->diffForHumans() }}</span>
                                <span class="text-[10px] text-slate-400">{{ $answer->created_at->format('H:i | d M') }}</span>
                            </div>
                        </td>

                        {{-- Admin Actions --}}
                        <td class="px-10 py-5 text-right">
                            <div class="flex justify-end gap-1 opacity-0 group-hover:opacity-100 transition-all duration-300">
                                <button class="p-2.5 text-slate-400 hover:text-amber-500 hover:bg-amber-50 rounded-xl transition-all" title="Flag for Review">
                                    <span class="material-symbols-outlined text-xl">flag</span>
                                </button>
                                <form action="{{ route('admin.delete.answer', $answer->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete this answer?')" class="p-2.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all">
                                        <span class="material-symbols-outlined text-xl">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-10 py-24 text-center">
                            <span class="material-symbols-outlined text-5xl text-slate-200 mb-4">chat_bubble_outline</span>
                            <p class="text-slate-400 font-bold uppercase tracking-widest text-xs">No responses found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection