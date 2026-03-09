@extends('layouts.adminLayout')

@section('title', 'User Directory')

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
    {{-- Header Section --}}
    <header class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <nav class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3">
                <a href="/admin/dashboard" class="hover:text-primary transition-colors">Admin</a>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span class="text-slate-900">Users</span>
            </nav>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight leading-none">
                System <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-emerald-400">Directory</span>
            </h1>
            <p class="text-slate-400 font-medium mt-2">Manage user permissions and account status</p>
        </div>

    </header>

    {{-- Filter Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-4 rounded-2xl border border-slate-200 flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined">group</span>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase">Total Users</p>
                <p class="text-xl font-black text-slate-900">{{ $users->count() }}</p>
            </div>
        </div>
    </div>

    {{-- User Table Card --}}
    <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/30 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">User Profile</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Role</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Activity</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Joined</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                    <tr class="group hover:bg-slate-50/50 transition-all duration-200">
                        {{-- User Profile --}}
                        <td class="px-10 py-5">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=f1f5f9&color=64748b" class="w-11 h-11 rounded-2xl border-2 border-white shadow-sm">
                                    <div class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-emerald-500 border-2 border-white rounded-full"></div>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-900">{{ $user->name }}</span>
                                    <span class="text-xs text-slate-400 font-medium">{{ $user->email }}</span>
                                </div>
                            </div>
                        </td>

                        {{-- Role Badge --}}
                        <td class="px-10 py-5">
                            @if($user->is_admin) {{-- Assuming you have an is_admin check --}}
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-slate-900 text-white">Admin</span>
                            @else
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-emerald-100 text-emerald-700 border border-emerald-200/50">User</span>
                            @endif
                        </td>

                        {{-- Activity Stats --}}
                        <td class="px-10 py-5">
                            <div class="flex items-center gap-4 text-xs font-bold text-slate-600">
                                <div class="flex items-center gap-1.5" title="Questions Posted">
                                    <span class="material-symbols-outlined text-[16px] text-slate-300">help</span>
                                    {{ $user->questions_count ?? 0 }}
                                </div>
                                <div class="flex items-center gap-1.5" title="Answers Given">
                                    <span class="material-symbols-outlined text-[16px] text-slate-300">chat</span>
                                    {{ $user->answers_count ?? 0 }}
                                </div>
                            </div>
                        </td>

                        {{-- Join Date --}}
                        <td class="px-10 py-5 text-xs font-bold text-slate-400 uppercase">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>

                        {{-- Actions --}}
                        <td class="px-10 py-5 text-right">
                            <div class="flex justify-end gap-1 opacity-0 group-hover:opacity-100 transition-all duration-300">
                                <form action="{{route('admin.delete.user',$user->id)}}" method="post" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete this answer?')" class="p-2.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all">
                                        <span class="material-symbols-outlined text-xl">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    {{-- Empty state tr --}}
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection