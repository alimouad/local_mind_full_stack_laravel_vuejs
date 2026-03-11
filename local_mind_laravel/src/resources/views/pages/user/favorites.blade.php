@extends('layouts.userLayout')

@section('title', 'My Favorites')

@section('content')
<div class="max-w-5xl mx-auto px-4">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div class="flex items-center gap-4">
            <div class="h-14 w-14 rounded-2xl bg-amber-50 flex items-center justify-center border border-amber-100 shadow-sm shadow-amber-100">
                <svg class="w-7 h-7 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Saved Questions</h1>
                <p class="text-slate-500 mt-1 font-medium">Items you've marked for later reference.</p>
            </div>
        </div>

        <div class="text-sm font-bold text-slate-400 bg-white px-4 py-2 rounded-xl border border-slate-200">
            Total: <span class="text-amber-600 ml-1">{{ $favoriteQuestions->count() }}</span>
        </div>
    </div>

    <div class="grid gap-5">
        @forelse($favoriteQuestions as $question)
            <div class="group bg-white p-6 rounded-3xl border border-slate-200/60 shadow-sm hover:shadow-xl hover:shadow-amber-900/5 hover:border-amber-200/40 transition-all duration-300">
                <div class="flex flex-col md:flex-row gap-6">
                    
                    <div class="flex-grow">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-[10px] font-black uppercase tracking-wider bg-amber-50 text-amber-600 border border-amber-100/50">
                                Saved Item
                            </span>
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-tight">
                                {{ $question->created_at->format('M d, Y') }}
                            </span>
                        </div>

                        <a href="{{ route('question.view', $question->id) }}" class="group/link">
                            <h2 class="text-xl font-bold text-slate-900 mb-2 leading-tight group-hover/link:text-amber-600 transition-colors">
                                {{ $question->title }}
                            </h2>
                        </a>

                        <p class="text-slate-500 text-sm leading-relaxed line-clamp-2 mb-6">
                            {{ Str::limit($question->content, 150) }}
                        </p>

                        <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                            <div class="flex items-center gap-2">
                                <img src="https://ui-avatars.com/api/?name={{ $question->user->name }}&background=f59e0b&color=fff" class="w-6 h-6 rounded-lg">
                                <span class="text-xs font-bold text-slate-600">{{ $question->user->name }}</span>
                            </div>

                            <div class="flex items-center gap-4">
                                <a href="{{ route('question.view', $question->id) }}" class="text-xs font-extrabold text-primary hover:text-primaryDark transition-colors">
                                    View Discussion &rarr;
                                </a>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-24 bg-white rounded-[2.5rem] border-2 border-dashed border-slate-200">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-amber-50 text-amber-200 mb-6">
                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900">Your collection is empty</h3>
                <p class="text-slate-500 mb-8 max-w-xs mx-auto font-medium">See something interesting? Click the star icon to save it here for later.</p>
                <a href="{{ route('questions.index') }}" class="inline-flex items-center px-8 py-3 bg-slate-900 text-white font-bold rounded-2xl hover:bg-slate-800 transition-all active:scale-95 shadow-xl shadow-slate-200">
                    Browse Feed
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection