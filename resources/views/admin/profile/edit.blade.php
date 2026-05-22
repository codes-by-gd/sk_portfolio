@extends('layouts.admin')

@section('title', __('messages.admin.profile') . ' - Admin Portal')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="font-heading font-extrabold text-3xl text-base-content">{{ __('messages.admin.profile') }}</h1>
        <p class="text-xs text-base-content/50 font-bold uppercase tracking-wider mt-1">Manage your administrative credentials, profile avatar, and security settings</p>
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

<form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Profile Details Card -->
    <div class="bg-base-100 card-base border border-base-300 rounded-2xl shadow-sm p-6">
        <h2 class="font-heading font-bold text-lg text-base-content mb-5 flex items-center gap-2">
            <i class="fa-solid fa-user-gear text-primary"></i> Personal Profile Information
        </h2>

        <!-- Avatar Upload Section -->
        <div class="flex flex-col sm:flex-row items-center gap-6 mb-6 pb-6 border-b border-base-200">
            <!-- Avatar Display -->
            <div class="avatar placeholder shrink-0">
                <div class="bg-primary text-white rounded-full w-24 h-24 shadow-md ring ring-primary ring-offset-base-100 ring-offset-2 overflow-hidden flex items-center justify-center">
                    @if($user->avatar_path)
                        <img src="{{ asset($user->avatar_path) }}" alt="{{ $user->name }}" class="object-cover w-full h-full" />
                    @else
                        <span class="text-3xl font-extrabold font-heading select-none">
                            {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
                        </span>
                    @endif
                </div>
            </div>
            <!-- Avatar Input -->
            <div class="form-control w-full max-w-xs">
                <label class="label py-1">
                    <span class="label-text font-bold text-xs uppercase tracking-wider text-base-content/75">{{ __('messages.admin.avatar') }}</span>
                </label>
                <input type="file" name="avatar" class="file-input file-input-bordered file-input-primary w-full max-w-xs rounded-xl shadow-sm h-12 min-h-12 text-sm" accept="image/*" />
                <span class="label-text-alt mt-1.5 text-base-content/40 italic">Accepts WebP, JPG, PNG, GIF. Max: 2MB.</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="form-control w-full">
                <x-float-input 
                    type="text" 
                    name="first_name" 
                    label="{{ __('messages.admin.first_name') }}" 
                    value="{{ $user->first_name }}" 
                    required="true"
                />
            </div>
            <div class="form-control w-full">
                <x-float-input 
                    type="text" 
                    name="last_name" 
                    label="{{ __('messages.admin.last_name') }}" 
                    value="{{ $user->last_name }}" 
                    required="true"
                />
            </div>
            <div class="form-control w-full">
                <x-float-input 
                    type="email" 
                    name="email" 
                    label="{{ __('messages.admin.email') }}" 
                    value="{{ $user->email }}" 
                    required="true"
                />
            </div>
        </div>
    </div>

    <!-- Password Change Card -->
    <div class="bg-base-100 card-base border border-base-300 rounded-2xl shadow-sm p-6 mt-6">
        <h2 class="font-heading font-bold text-lg text-base-content mb-5 flex items-center gap-2">
            <i class="fa-solid fa-key text-primary"></i> Security & Password Update
        </h2>
        <p class="text-xs text-base-content/50 mb-6 italic">Leave password fields blank if you do not wish to change your current password.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="form-control w-full">
                <x-float-input 
                    type="password" 
                    name="current_password" 
                    label="{{ __('messages.admin.current_password') }}" 
                />
            </div>
            <div class="form-control w-full">
                <x-float-input 
                    type="password" 
                    name="password" 
                    label="{{ __('messages.admin.new_password') }}" 
                />
            </div>
            <div class="form-control w-full">
                <x-float-input 
                    type="password" 
                    name="password_confirmation" 
                    label="{{ __('messages.admin.confirm_password') }}" 
                />
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary text-white font-bold rounded-xl gap-2 shadow-md mt-6 h-12 min-h-12 px-6">
        <i class="fa-solid fa-floppy-disk text-base"></i> {{ __('messages.admin.update_profile') }}
    </button>
</form>
@endsection
