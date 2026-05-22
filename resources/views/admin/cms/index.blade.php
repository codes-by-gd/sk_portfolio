@extends('layouts.admin')

@section('title', 'CMS Content Management - Admin Portal')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="font-heading font-extrabold text-3xl text-base-content">CMS Content</h1>
        <p class="text-xs text-base-content/50 font-bold uppercase tracking-wider mt-1">Edit multilingual website text content</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success shadow-sm rounded-xl text-white">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <span class="text-sm font-semibold">{{ session('success') }}</span>
    </div>
@endif

<div class="space-y-4">
    @forelse($pages as $page)
        <div class="bg-base-100 card-base border border-base-300 rounded-2xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <span class="badge badge-secondary text-white font-mono text-xs px-3 py-2.5">{{ $page->key }}</span>
            </div>
            <form action="{{ route('admin.cms.update', $page) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="form-control">
                    <label class="label"><span class="label-text font-bold text-xs text-base-content/75 uppercase tracking-wider">English *</span></label>
                    @if(strlen($page->content_en) > 100)
                        <textarea name="content_en" required rows="3" class="textarea textarea-bordered rounded-xl bg-transparent border-base-300 w-full text-sm text-base-content">{{ $page->content_en }}</textarea>
                    @else
                        <input type="text" name="content_en" required value="{{ $page->content_en }}" class="input input-bordered rounded-xl bg-transparent border-base-300 w-full text-sm text-base-content">
                    @endif
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text font-bold text-xs text-base-content/75 uppercase tracking-wider">ગુજરાતી</span></label>
                        @if(strlen($page->content_en) > 100)
                            <textarea name="content_gu" rows="3" class="textarea textarea-bordered rounded-xl bg-transparent border-base-300 w-full text-sm text-base-content">{{ $page->content_gu }}</textarea>
                        @else
                            <input type="text" name="content_gu" value="{{ $page->content_gu }}" class="input input-bordered rounded-xl bg-transparent border-base-300 w-full text-sm text-base-content">
                        @endif
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text font-bold text-xs text-base-content/75 uppercase tracking-wider">हिंदी</span></label>
                        @if(strlen($page->content_en) > 100)
                            <textarea name="content_hi" rows="3" class="textarea textarea-bordered rounded-xl bg-transparent border-base-300 w-full text-sm text-base-content">{{ $page->content_hi }}</textarea>
                        @else
                            <input type="text" name="content_hi" value="{{ $page->content_hi }}" class="input input-bordered rounded-xl bg-transparent border-base-300 w-full text-sm text-base-content">
                        @endif
                    </div>
                </div>
                <button type="submit" class="btn btn-sm btn-primary text-white font-bold rounded-xl gap-2 mt-2">
                    <i class="fa-solid fa-floppy-disk"></i> Update
                </button>
            </form>
        </div>
    @empty
        <div class="bg-base-100 card-base border border-base-300 rounded-2xl p-8 text-center text-base-content/50 italic text-sm">
            No CMS pages found. Run database seeders to populate content.
        </div>
    @endforelse
</div>
@endsection
