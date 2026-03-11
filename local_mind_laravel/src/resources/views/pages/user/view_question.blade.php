@extends('layouts.userLayout')

@section('title', $question->title)

@section('content')
<div class="max-w-4xl mx-auto px-4">


    @if(session('success'))
    <div
        x-data="{ show: true }"
        x-show="show"
        x-init="setTimeout(() => show = false, 3000)"
        class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 text-sm">
        {{ session('success') }}
    </div>
    @endif
    @if (session('error'))
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        {{ session('error') }}
    </div>
    @endif


    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('home') }}" class="group flex items-center text-sm font-semibold text-slate-500 hover:text-primary transition-colors">
            <svg class="w-5 h-5 mr-1 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Feed
        </a>
    
        @can('delete', $question)
        <div class="flex items-center gap-2">
            <a href="/" class="px-4 py-2 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all">
                Edit
            </a>
            <form action="{{ route('question.delete', $question->id) }}" method="POST" onsubmit="return confirm('Delete this question permanently?')">
                @csrf @method('DELETE')
                <button class="px-4 py-2 text-sm font-bold text-red-600 bg-red-50 rounded-xl hover:bg-red-100 transition-all">
                    Delete
                </button>
            </form>
        </div>
        @endcan

    </div>

    <article class="bg-white rounded-3xl border border-slate-200/60 shadow-sm overflow-hidden">
        <div class="p-8 pb-4 relative">

            @auth
            <div class="absolute top-8 right-8">
                <form action="{{ route('questions.favorite', $question->id) }}" method="POST">
                    @csrf
                    @php $isFavorited = $question->isFavorited(); @endphp

                    <button
                        type="submit"
                        class="group flex items-center gap-2 px-4 py-2 rounded-2xl border transition-all duration-300 shadow-sm
            {{ $isFavorited
                ? 'bg-amber-50 border-amber-200 text-amber-600 shadow-amber-100'
                : 'bg-white border-slate-200 text-slate-400 hover:border-amber-200 hover:text-amber-500' }}">

                        <svg
                            class="w-5 h-5 transition-transform duration-300 group-active:scale-125
                {{ $isFavorited ? 'fill-current' : 'fill-none' }}"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.563.563 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                        </svg>

                        <span class="text-xs font-bold uppercase tracking-wider">
                            {{ $isFavorited ? 'Saved' : 'Save' }}
                        </span>
                    </button>
                </form>
            </div>
            @endauth


            <div class="flex items-center gap-3 mb-4">
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                    Active Question
                </span>
                <span class="text-xs font-medium text-slate-400">
                    Posted {{ $question->created_at->diffForHumans() }}
                </span>
            </div>

            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 leading-tight mb-6 pr-24">
                {{ $question->title }}
            </h1>

            <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                <img src="https://ui-avatars.com/api/?name={{ $question->user->name ?? 'U' }}&background=059669&color=fff" class="w-10 h-10 rounded-xl shadow-sm">
                <div>
                    <p class="text-sm font-bold text-slate-900">{{ $question->user->name ?? 'Community Member' }}</p>
                    <p class="text-xs text-slate-500 font-medium">Author • Trusted Member</p>
                </div>
            </div>
        </div>

        <div class="px-8 py-6">
            <div class="prose prose-slate max-w-none">
                <p class="text-lg text-slate-700 leading-relaxed whitespace-pre-line">
                    {{ $question->content }}
                </p>
            </div>
        </div>

        <div class="bg-slate-50/50 border-t border-slate-100 p-8">
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 flex items-center">
                <svg class="w-4 h-4 mr-2 text-primary" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                </svg>
                Location Details
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-3">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase">Address</p>
                        <p class="text-slate-700 font-medium">{{ $question->location }}</p>
                    </div>
                    <div class="flex gap-4">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Latitude</p>
                            <code class="text-xs bg-white px-2 py-1 rounded border border-slate-200">{{ $question->latitude }}</code>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Longitude</p>
                            <code class="text-xs bg-white px-2 py-1 rounded border border-slate-200">{{ $question->longitude }}</code>
                        </div>
                    </div>
                </div>

                <div class="h-32 rounded-2xl bg-slate-200 border border-slate-300 overflow-hidden flex items-center justify-center relative">
                    <span class="text-xs font-bold text-slate-500 z-10">Map Preview Placeholder</span>
                    <div class="absolute inset-0 opacity-20 bg-[radial-gradient(#059669_1px,transparent_1px)] [background-size:16px_16px]"></div>
                </div>
            </div>
        </div>
    </article>

    <div class="max-w-4xl mx-auto px-4 py-10">

        <div class="flex items-center justify-between mb-8 border-b border-slate-200 pb-4">
            <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                Discussion
                <span class="ml-2 text-slate-400 font-medium text-lg">
                    ({{ $question->answers->count() }})
                </span>
            </h3>

            @if($question->answers->count() === 0)
            <div class="flex items-center gap-2 text-sm font-bold text-primary">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                Be the first to help
            </div>
            @endif
        </div>

        <div class="space-y-6 mb-12">
            @forelse($question->answers as $answer)
            <div class="group relative flex flex-col sm:flex-row gap-4 p-6 bg-white rounded-3xl border border-slate-200/60 shadow-sm transition-all hover:shadow-md">

                <div class="flex sm:flex-col items-center justify-center gap-2 sm:w-12 bg-slate-50/50 rounded-2xl p-1">
                    <button class="p-1.5 text-slate-400 hover:text-primary hover:bg-white rounded-lg transition-all">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <span class="text-sm font-black text-slate-700">0</span>
                    <button class="p-1.5 text-slate-400 hover:text-red-500 hover:bg-white rounded-lg transition-all">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                <div class="flex-grow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name={{ $answer->user->name ?? 'U' }}&background=059669&color=fff" class="w-9 h-9 rounded-xl shadow-sm">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-bold text-slate-900">{{ $answer->user->name ?? 'User' }}</span>
                                    @if($answer->user_id === $question->user_id)
                                    <span class="px-2 py-0.5 rounded-md bg-emerald-100 text-[10px] font-black uppercase text-emerald-700 tracking-wider">Author</span>
                                    @endif
                                </div>
                                <span class="text-[11px] text-slate-400 font-medium">{{ $answer->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        @if(auth()->id() === $answer->user_id)
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="p-2 text-slate-300 hover:text-slate-600 hover:bg-slate-50 rounded-lg transition-all">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-32 bg-white rounded-xl shadow-xl border border-slate-100 z-10 py-1">
                                <a href="#" class="block px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-50">Edit</a>
                                <button class="block w-full text-left px-4 py-2 text-xs font-bold text-red-600 hover:bg-red-50">Delete</button>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="text-slate-700 text-sm leading-relaxed whitespace-pre-line">
                        {{ $answer->content }}
                    </div>

                    <div class="mt-4 pt-4 border-t border-slate-50 flex items-center gap-6">
                        <button class="text-xs font-bold text-slate-400 hover:text-primary transition-colors flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                            </svg>
                            Reply
                        </button>
                        <button class="text-xs font-bold text-slate-400 hover:text-primary transition-colors">Share</button>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-16 bg-white rounded-3xl border-2 border-dashed border-slate-200">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-slate-50 text-slate-300 mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-slate-900">No answers yet</h3>
                <p class="text-xs text-slate-400">Be the first to share your knowledge.</p>
            </div>
            @endforelse
        </div>

        <div class="bg-white rounded-3xl border border-slate-200/60 shadow-sm overflow-hidden border-t-4 border-t-primary">
            <form action="{{ route('answer.process', $question->id) }}" method="POST">
                @csrf
                <div class="p-6 sm:p-8">
                    <div class="flex items-start gap-5">
                        <div class="hidden sm:block">
                            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name ?? 'U' }}&background=059669&color=fff" class="w-12 h-12 rounded-xl shadow-md border-2 border-white">
                        </div>

                        <div class="flex-grow space-y-5">
                            <div class="relative">
                                <textarea
                                    name="content"
                                    rows="5"
                                    required
                                    placeholder="What are your thoughts on this?"
                                    class="w-full px-6 py-5 rounded-2xl bg-slate-50 border-2 border-transparent focus:bg-white focus:border-emerald-500/20 focus:ring-4 focus:ring-emerald-500/5 text-slate-700 placeholder-slate-400 transition-all outline-none resize-none shadow-inner"></textarea>
                                @error('content')
                                <p class="mt-2 text-sm text-red-500 font-medium px-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-2">
                                <div class="flex items-center gap-2 text-slate-400 bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
                                    <span class="text-lg">💡</span>
                                    <p class="text-[11px] font-bold uppercase tracking-wider">Helpful & Respectful</p>
                                </div>
                                <button
                                    type="submit"
                                    class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 bg-primary hover:bg-primaryDark text-white font-black rounded-xl shadow-lg shadow-emerald-200 transition-all active:scale-[0.96] gap-3">
                                    <span>Post Answer</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection