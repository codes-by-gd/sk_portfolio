@extends('layouts.admin')

@section('title', 'User Management - Admin Portal')

@section('content')
{{-- Page Header --}}
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="font-heading font-extrabold text-3xl text-base-content">User Management</h1>
        <p class="text-xs text-base-content/50 font-bold uppercase tracking-wider mt-1">Configure internal admin accounts, access roles, and authorization levels</p>
    </div>
    <button type="button" onclick="openAddUserModal()" class="btn btn-primary text-white font-bold rounded-xl gap-2 shadow-md">
        <i class="fa-solid fa-user-plus text-base"></i> Add Administrator
    </button>
</div>

{{-- Alerts --}}
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

{{-- Users Table --}}
<div class="bg-base-100 card-base border border-base-300 rounded-2xl overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="table table-md w-full text-left">
            <thead class="bg-base-200 text-xs font-bold uppercase tracking-wider text-base-content/70 border-b border-base-300">
                <tr>
                    <th class="py-4">Administrator</th>
                    <th class="py-4">Email</th>
                    <th class="py-4">Role</th>
                    <th class="py-4">Status</th>
                    <th class="py-4">Registered</th>
                    <th class="py-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-base-300 text-sm text-base-content">
                @foreach($users as $user)
                    <tr class="hover:bg-base-200/50 transition-colors">
                        <td class="py-4">
                            <div class="flex items-center gap-2.5">
                                <div class="w-9 h-9 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-extrabold text-xs shrink-0 overflow-hidden">
                                    @if($user->avatar_path)
                                        <img src="{{ asset($user->avatar_path) }}" alt="{{ $user->name }}" class="object-cover w-full h-full">
                                    @else
                                        {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
                                    @endif
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-bold text-base-content leading-tight">{{ $user->name }}</span>
                                    @if(auth()->id() === $user->id)
                                        <span class="badge badge-primary badge-xs font-bold uppercase text-[9px] mt-0.5">Active Session</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="py-4 text-xs font-semibold text-base-content/80">{{ $user->email }}</td>
                        <td class="py-4">
                            @if($user->role === 'super_admin')
                                <span class="badge badge-error badge-sm font-bold text-[9px] uppercase gap-1">
                                    <i class="fa-solid fa-shield-halved text-[9px]"></i> Super Admin
                                </span>
                            @elseif($user->role === 'moderator')
                                <span class="badge badge-info badge-sm font-bold text-[9px] uppercase gap-1">
                                    <i class="fa-solid fa-comments text-[9px]"></i> Moderator
                                </span>
                            @else
                                <span class="badge badge-success badge-sm font-bold text-[9px] uppercase gap-1">
                                    <i class="fa-solid fa-pen-nib text-[9px]"></i> Editor
                                </span>
                            @endif
                        </td>
                        <td class="py-4">
                            @if($user->is_active)
                                <span class="badge badge-success badge-outline badge-sm font-bold text-[9px] uppercase">Active</span>
                            @else
                                <span class="badge badge-ghost badge-sm font-bold text-[9px] uppercase opacity-60">Suspended</span>
                            @endif
                        </td>
                        <td class="py-4 text-xs font-semibold opacity-60">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="py-4 text-center">
                            <div class="flex gap-1.5 justify-center">
                                <button type="button"
                                    onclick="openEditUserModal({{ json_encode($user) }})"
                                    class="btn btn-sm btn-square btn-soft btn-info tooltip tooltip-top"
                                    data-tip="Edit Account">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                @if(auth()->id() !== $user->id)
                                    <form action="{{ route('admin.user.destroy', $user) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Delete this administrator account permanently?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-square btn-soft btn-error tooltip tooltip-top" data-tip="Delete Account">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-sm btn-square btn-soft btn-error tooltip tooltip-top opacity-30 cursor-not-allowed" data-tip="Cannot delete active session" disabled>
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
        <div class="p-4 border-t border-base-300 flex justify-center">
            {{ $users->links() }}
        </div>
    @endif
</div>

{{-- ========== ADD USER MODAL ========== --}}
<div id="add-user-modal" class="modal modal-bottom sm:modal-middle transition-all duration-300 z-50">
    <div class="modal-box bg-base-100 border border-base-300 rounded-2xl shadow-xl max-w-lg p-6 relative">
        <button type="button" onclick="closeAddUserModal()" class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-base-content/60 hover:text-base-content">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
        <h3 class="font-heading font-extrabold text-xl text-base-content mb-1 flex items-center gap-2">
            <i class="fa-solid fa-user-plus text-primary"></i> Register Administrator
        </h3>
        <p class="text-xs text-base-content/50 uppercase tracking-wider font-bold mb-6">Create a new admin account with a specific access role</p>

        <form action="{{ route('admin.user.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="form-control">
                    <x-float-input type="text" name="first_name" label="First Name" required="true" />
                </div>
                <div class="form-control">
                    <x-float-input type="text" name="last_name" label="Last Name" required="true" />
                </div>
            </div>
            <div class="form-control">
                <x-float-input type="email" name="email" label="Email Address" required="true" />
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="form-control">
                    <x-float-input type="password" name="password" label="Password" required="true" />
                </div>
                <div class="form-control">
                    <x-float-input type="password" name="password_confirmation" label="Confirm Password" required="true" />
                </div>
            </div>
            <div class="form-control">
                <label class="floating-label w-full block relative">
                    <span>Access Role <span class="text-error font-extrabold">*</span></span>
                    <select name="role" required class="select select-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all appearance-none pr-10">
                        <option value="moderator" selected>Content Moderator (Feedbacks &amp; Grievances)</option>
                        <option value="editor">Content Editor (Works, CMS, Gallery)</option>
                        <option value="super_admin">Super Admin (Full Access)</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 pt-3 text-base-content/50">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </label>
            </div>
            <div class="flex justify-end gap-2.5 pt-4 border-t border-base-300 mt-6">
                <button type="button" onclick="closeAddUserModal()" class="btn btn-ghost hover:bg-base-200 rounded-xl px-5 text-sm font-semibold">Cancel</button>
                <button type="submit" class="btn btn-primary text-white font-bold rounded-xl px-6 shadow-md gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Register Admin
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ========== EDIT USER MODAL ========== --}}
<div id="edit-user-modal" class="modal modal-bottom sm:modal-middle transition-all duration-300 z-50">
    <div class="modal-box bg-base-100 border border-base-300 rounded-2xl shadow-xl max-w-lg p-6 relative">
        <button type="button" onclick="closeEditUserModal()" class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-base-content/60 hover:text-base-content">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
        <h3 class="font-heading font-extrabold text-xl text-base-content mb-1 flex items-center gap-2">
            <i class="fa-solid fa-pen-to-square text-primary"></i> Edit Administrator
        </h3>
        <p class="text-xs text-base-content/50 uppercase tracking-wider font-bold mb-6">Modify account details, role or access status</p>

        <form id="edit-user-form" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="form-control">
                    <x-float-input type="text" name="first_name" id="edit-first-name" label="First Name" required="true" />
                </div>
                <div class="form-control">
                    <x-float-input type="text" name="last_name" id="edit-last-name" label="Last Name" required="true" />
                </div>
            </div>
            <div class="form-control">
                <x-float-input type="email" name="email" id="edit-email" label="Email Address" required="true" />
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="floating-label w-full block relative">
                        <span>Access Role <span class="text-error font-extrabold">*</span></span>
                        <select id="edit-role" name="role" required class="select select-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all appearance-none pr-10">
                            <option value="moderator">Content Moderator</option>
                            <option value="editor">Content Editor</option>
                            <option value="super_admin">Super Admin</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 pt-3 text-base-content/50">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </label>
                </div>
                <div class="form-control">
                    <label class="floating-label w-full block relative">
                        <span>Account Status <span class="text-error font-extrabold">*</span></span>
                        <select id="edit-is-active" name="is_active" required class="select select-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all appearance-none pr-10">
                            <option value="1">Active</option>
                            <option value="0">Suspended</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 pt-3 text-base-content/50">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </label>
                </div>
            </div>
            <div class="flex justify-end gap-2.5 pt-4 border-t border-base-300 mt-6">
                <button type="button" onclick="closeEditUserModal()" class="btn btn-ghost hover:bg-base-200 rounded-xl px-5 text-sm font-semibold">Cancel</button>
                <button type="submit" class="btn btn-primary text-white font-bold rounded-xl px-6 shadow-md gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    window.openAddUserModal = function () {
        document.getElementById('add-user-modal').classList.add('modal-open');
    };
    window.closeAddUserModal = function () {
        document.getElementById('add-user-modal').classList.remove('modal-open');
    };

    window.openEditUserModal = function (user) {
        document.getElementById('edit-user-form').action = `/admin/users/${user.id}`;
        document.getElementById('edit-first-name').value = user.first_name || '';
        document.getElementById('edit-last-name').value = user.last_name || '';
        document.getElementById('edit-email').value = user.email || '';
        document.getElementById('edit-role').value = user.role || 'moderator';
        document.getElementById('edit-is-active').value = user.is_active ? '1' : '0';

        // Prevent self-demotion
        const loggedInUserId = {{ auth()->id() }};
        const isSelf = user.id == loggedInUserId;
        document.getElementById('edit-role').disabled = isSelf;
        document.getElementById('edit-is-active').disabled = isSelf;

        document.getElementById('edit-user-modal').classList.add('modal-open');
    };
    window.closeEditUserModal = function () {
        document.getElementById('edit-user-modal').classList.remove('modal-open');
    };
});
</script>
@endsection
