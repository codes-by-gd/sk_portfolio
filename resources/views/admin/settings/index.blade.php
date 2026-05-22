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
                <label class="floating-label w-full block">
                    <span>Office Address</span>
                    <textarea 
                        name="office_address" 
                        id="office_address" 
                        rows="2" 
                        placeholder="Office Address"
                        class="textarea textarea-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all h-20"
                    >{{ $settings['office_address']->value ?? '' }}</textarea>
                </label>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control">
                    <x-float-input 
                        type="text" 
                        name="office_phone" 
                        label="Phone Number(s)" 
                        value="{{ $settings['office_phone']->value ?? '' }}"
                    />
                </div>
                <div class="form-control">
                    <x-float-input 
                        type="email" 
                        name="office_email" 
                        label="Email Address" 
                        value="{{ $settings['office_email']->value ?? '' }}"
                    />
                </div>
            </div>
            <div class="form-control">
                <x-float-input 
                    type="text" 
                    name="office_timings" 
                    label="Office Timings" 
                    value="{{ $settings['office_timings']->value ?? '' }}"
                />
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
                <x-float-input 
                    type="url" 
                    name="facebook_url" 
                    label="Facebook URL" 
                    value="{{ $settings['facebook_url']->value ?? '' }}"
                />
            </div>
            <div class="form-control">
                <x-float-input 
                    type="url" 
                    name="twitter_url" 
                    label="Twitter/X URL" 
                    value="{{ $settings['twitter_url']->value ?? '' }}"
                />
            </div>
            <div class="form-control">
                <x-float-input 
                    type="url" 
                    name="instagram_url" 
                    label="Instagram URL" 
                    value="{{ $settings['instagram_url']->value ?? '' }}"
                />
            </div>
            <div class="form-control">
                <x-float-input 
                    type="url" 
                    name="youtube_url" 
                    label="YouTube URL" 
                    value="{{ $settings['youtube_url']->value ?? '' }}"
                />
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary text-white font-bold rounded-xl gap-2 shadow-md mt-6">
        <i class="fa-solid fa-floppy-disk"></i> Save All Settings
    </button>
</form>
@endsection
