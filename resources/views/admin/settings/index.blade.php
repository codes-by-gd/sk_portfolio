@extends('layouts.admin')

@section('title', 'Settings - Admin Portal')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="font-heading font-extrabold text-3xl text-base-content">Settings</h1>
        <p class="text-xs text-base-content/50 font-bold uppercase tracking-wider mt-1">Manage office contact details and social links</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success shadow-sm rounded-xl text-white">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <span class="text-sm font-semibold">{{ session('success') }}</span>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-error shadow-sm rounded-xl text-white">
        <ul class="text-xs list-disc pl-4 font-medium">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
    @csrf

    <!-- Contact Information Card -->
    <div class="bg-base-100 card-base border border-base-300 rounded-2xl shadow-sm p-6">
        <h2 class="font-heading font-bold text-lg text-base-content mb-5 flex items-center gap-2">
            <i class="fa-solid fa-building text-primary"></i> Office Information
        </h2>
        <div class="space-y-4">
            <div class="form-control">
                <label class="label"><span class="label-text font-bold text-xs text-base-content/75 uppercase tracking-wider">Office Address</span></label>
                <textarea name="office_address" rows="2" class="textarea textarea-bordered rounded-xl bg-transparent border-base-300 w-full text-base-content" placeholder="Enter full office address">{{ $settings['office_address']->value ?? '' }}</textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label"><span class="label-text font-bold text-xs text-base-content/75 uppercase tracking-wider">Phone Number(s)</span></label>
                    <input type="text" name="office_phone" value="{{ $settings['office_phone']->value ?? '' }}" class="input input-bordered rounded-xl bg-transparent border-base-300 w-full text-base-content" placeholder="+91 XXXXX XXXXX">
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-bold text-xs text-base-content/75 uppercase tracking-wider">Email Address</span></label>
                    <input type="email" name="office_email" value="{{ $settings['office_email']->value ?? '' }}" class="input input-bordered rounded-xl bg-transparent border-base-300 w-full text-base-content" placeholder="office@example.com">
                </div>
            </div>
            <div class="form-control">
                <label class="label"><span class="label-text font-bold text-xs text-base-content/75 uppercase tracking-wider">Office Timings</span></label>
                <input type="text" name="office_timings" value="{{ $settings['office_timings']->value ?? '' }}" class="input input-bordered rounded-xl bg-transparent border-base-300 w-full text-base-content" placeholder="e.g. Mon–Sat: 10:00 AM – 6:00 PM">
            </div>
        </div>
    </div>

    <!-- Social Links Card -->
    <div class="bg-base-100 card-base border border-base-300 rounded-2xl shadow-sm p-6 mt-6">
        <h2 class="font-heading font-bold text-lg text-base-content mb-5 flex items-center gap-2">
            <i class="fa-solid fa-share-nodes text-primary"></i> Social Media Links
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-bold text-xs text-base-content/75 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-brands fa-facebook text-blue-600"></i> Facebook URL
                    </span>
                </label>
                <input type="url" name="facebook_url" value="{{ $settings['facebook_url']->value ?? '' }}" class="input input-bordered rounded-xl bg-transparent border-base-300 w-full text-base-content" placeholder="https://facebook.com/...">
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-bold text-xs text-base-content/75 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-brands fa-twitter text-sky-500"></i> Twitter/X URL
                    </span>
                </label>
                <input type="url" name="twitter_url" value="{{ $settings['twitter_url']->value ?? '' }}" class="input input-bordered rounded-xl bg-transparent border-base-300 w-full text-base-content" placeholder="https://twitter.com/...">
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-bold text-xs text-base-content/75 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-brands fa-instagram text-pink-600"></i> Instagram URL
                    </span>
                </label>
                <input type="url" name="instagram_url" value="{{ $settings['instagram_url']->value ?? '' }}" class="input input-bordered rounded-xl bg-transparent border-base-300 w-full text-base-content" placeholder="https://instagram.com/...">
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-bold text-xs text-base-content/75 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-brands fa-youtube text-red-600"></i> YouTube URL
                    </span>
                </label>
                <input type="url" name="youtube_url" value="{{ $settings['youtube_url']->value ?? '' }}" class="input input-bordered rounded-xl bg-transparent border-base-300 w-full text-base-content" placeholder="https://youtube.com/@...">
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary text-white font-bold rounded-xl gap-2 shadow-md mt-6">
        <i class="fa-solid fa-floppy-disk"></i> Save All Settings
    </button>
</form>
@endsection
