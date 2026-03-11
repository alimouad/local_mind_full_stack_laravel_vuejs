@extends('layouts.userLayout')

@section('title', 'Post a Geolocation Question')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">

    @if(session('success'))
    <div
        x-data="{ show: true }"
        x-show="show"
        x-init="setTimeout(() => show = false, 3000)"
        class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 text-sm">
        {{ session('success') }}
    </div>
    @endif

    <nav class="flex mb-4 text-sm text-slate-500" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2">
            <li><a href="{{route('home')}}" class="hover:text-primary">Dashboard</a></li>
            <li><svg class="h-5 w-5 text-slate-300" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" />
                </svg></li>
            <li class="text-slate-900 font-medium">New Question</li>
        </ol>
    </nav>

    <form method="POST" action="{{ route('question.process') }}" class="space-y-8" novalidate autocomplete>
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-6 rounded-2xl border border-slate-200    shadow-sm">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Question Details</h3>

                    <div class="space-y-4">
                        <div>
                            <label for="title" class="block text-sm font-semibold text-slate-700 mb-1">Title</label>
                            <input type="text" name="title" id="title" placeholder="What's happening at this location?"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary transition-all outline-none">
                        </div>
                        @error('title')
                        <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror

                        <div>
                            <label for="content" class="block text-sm font-semibold text-slate-700 mb-1">Content</label>
                            <textarea name="content" id="content" rows="6" placeholder="Describe the situation..."
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary transition-all outline-none"></textarea>
                        </div>
                        @error('content')
                        <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <h3 class="text-lg font-bold text-slate-900">Location</h3>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Address/Name</label>
                            <input type="text" name="location" id="location" placeholder="e.g. Central Park, NY"
                                class="w-full px-3 py-2 text-sm rounded-lg border border-slate-200 focus:border-primary outline-none">
                        </div>
                        @error('location')
                        <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Latitude</label>
                                <input type="text" name="latitude" id="latitude"  class="w-full px-3 py-2 text-sm rounded-lg bg-slate-50 border border-slate-200 text-slate-500 cursor-not-allowed">
                            </div>
                            @error('latitude')
                            <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Longitude</label>
                                <input type="text" name="longitude" id="longitude"  class="w-full px-3 py-2 text-sm rounded-lg bg-slate-50 border border-slate-200 text-slate-500 cursor-not-allowed">
                            </div>
                            @error('longitude')
                            <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="button" onclick="getLocation()" class="w-full py-2 text-xs font-bold text-primary bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">
                            Detect My Location
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full py-4 bg-primary text-white font-bold rounded-2xl shadow-lg shadow-indigo-100 hover:bg-primary transition-all active:scale-[0.98]">
                    Publish Question
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

    function showPosition(position) {
        document.getElementById('latitude').value = position.coords.latitude;
        document.getElementById('longitude').value = position.coords.longitude;
        document.getElementById('location').value = "My Current Location";
    }
</script>
@endsection