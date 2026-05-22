@extends('layouts.admin')

@section('title', 'Development Works - Admin Portal')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="font-heading font-extrabold text-3xl text-neutral">Development Works</h1>
        <p class="text-xs text-neutral/50 font-bold uppercase tracking-wider mt-1">Manage ward development projects</p>
    </div>
    <a href="{{ route('admin.development.create') }}" class="btn btn-primary text-white font-bold rounded-xl gap-2 shadow-md">
        <i class="fa-solid fa-plus"></i> Add New Project
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success shadow-sm rounded-xl text-white">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <span class="text-sm font-semibold">{{ session('success') }}</span>
    </div>
@endif

<!-- Works Table -->
<div class="bg-[#FFFDF8] border border-base-300 rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="table table-md w-full text-left">
            <thead class="bg-base-200 text-xs font-bold uppercase tracking-wider text-neutral/70 border-b border-base-300">
                <tr>
                    <th class="py-4">Preview</th>
                    <th class="py-4">Title & Location</th>
                    <th class="py-4">Description</th>
                    <th class="py-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-base-300 text-sm text-neutral">
                @forelse($works as $work)
                    <tr class="hover:bg-base-100/50 transition-colors">
                        <!-- Before/After Preview -->
                        <td class="py-4 min-w-[140px]">
                            <div class="flex gap-1.5">
                                <div class="w-14 h-14 rounded-lg overflow-hidden border border-base-300 bg-base-200 flex items-center justify-center">
                                    @if($work->before_image)
                                        <img src="{{ asset($work->before_image) }}" class="object-cover w-full h-full" alt="Before">
                                    @else
                                        <i class="fa-solid fa-image text-neutral/30 text-lg"></i>
                                    @endif
                                </div>
                                <div class="w-14 h-14 rounded-lg overflow-hidden border border-base-300 bg-base-200 flex items-center justify-center">
                                    @if($work->after_image)
                                        <img src="{{ asset($work->after_image) }}" class="object-cover w-full h-full" alt="After">
                                    @else
                                        <i class="fa-solid fa-circle-check text-[#53C58B] text-lg"></i>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <!-- Title & Location -->
                        <td class="py-4 min-w-[200px]">
                            <p class="font-bold text-neutral leading-tight">{{ $work->title_en }}</p>
                            <p class="text-xs text-secondary font-semibold mt-1"><i class="fa-solid fa-location-dot mr-1 opacity-60"></i>{{ $work->location }}</p>
                        </td>
                        <!-- Description -->
                        <td class="py-4 max-w-xs">
                            <p class="text-xs text-neutral/75 line-clamp-3 leading-relaxed">{{ $work->description_en }}</p>
                        </td>
                        <!-- Actions -->
                        <td class="py-4 text-center">
                            <div class="flex gap-1.5 justify-center">
                                <a href="{{ route('admin.development.edit', $work) }}" class="btn btn-xs btn-outline btn-primary rounded-lg px-2.5 font-bold">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.development.destroy', $work) }}" method="POST" class="inline" onsubmit="return confirm('Delete this project?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-outline btn-error rounded-lg px-2.5">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-12 text-neutral/50 font-medium italic">
                            No development projects found. <a href="{{ route('admin.development.create') }}" class="text-primary underline">Add your first project</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($works->hasPages())
        <div class="p-4 border-t border-base-300 flex justify-center">
            {{ $works->links() }}
        </div>
    @endif
</div>
@endsection
