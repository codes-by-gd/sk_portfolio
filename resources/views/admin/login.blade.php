@extends('layouts.admin')

@section('title', __('messages.admin.login_title') . ' - Sachin Khandelwal')

@section('content')
<div class="w-full max-w-[420px] bg-neutral text-white border border-white/10 rounded-3xl p-8 sm:p-10 shadow-2xl relative overflow-hidden transition-all duration-300">
    <!-- Top accent stripe -->
    <div class="absolute top-0 left-0 w-full h-1.5 ribbon-gradient"></div>

    <div class="text-center space-y-2 mt-2">
        <div class="bg-primary text-white w-14 h-14 rounded-2xl flex items-center justify-center font-bold text-xl shadow-lg shadow-primary/25 mx-auto mb-4 animate-pulse">
            <i class="fa-solid fa-user-shield text-white"></i>
        </div>
        <h2 class="font-heading font-extrabold text-2xl text-white tracking-tight">
            {{ __('messages.admin.login_title') }}
        </h2>
        <p class="text-[10px] text-white/40 tracking-widest font-extrabold uppercase mt-1">Sachin Khandelwal Office</p>
    </div>

    <!-- Errors Alert -->
    @if($errors->any())
        <div class="alert alert-error shadow-sm rounded-xl text-white mt-5">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <div class="text-xs font-semibold">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        </div>
    @endif

    <form class="mt-8 space-y-5" action="{{ route('admin.login.submit') }}" method="POST">
        @csrf

        <!-- Floating Label Email -->
        <x-float-input 
            type="email" 
            name="email" 
            label="{{ __('messages.admin.email') }}" 
            required="true"
            inputClass="bg-white/5 border-white/10 text-white focus:border-primary focus:ring-0"
            labelClass="text-white/50 peer-focus:text-primary"
        />

        <!-- Floating Label Password -->
        <x-float-input 
            type="password" 
            name="password" 
            label="{{ __('messages.admin.password') }}" 
            required="true"
            inputClass="bg-white/5 border-white/10 text-white focus:border-primary focus:ring-0"
            labelClass="text-white/50 peer-focus:text-primary"
        />

        <!-- Remember option -->
        <div class="flex items-center justify-between text-xs font-semibold pt-1">
            <label class="flex items-center gap-2 cursor-pointer text-white/70 hover:text-white transition-all">
                <input type="checkbox" name="remember" class="checkbox checkbox-xs checkbox-primary rounded-md border-white/20 bg-white/5" />
                <span>Remember me</span>
            </label>
            <a href="#" class="text-primary hover:underline transition-all">Forgot password?</a>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary w-full text-white font-bold h-12 rounded-xl mt-4 hover:shadow-lg hover:shadow-primary/25 transition-all">
            {{ __('messages.admin.login_btn') }}
        </button>
    </form>
</div>
@endsection
