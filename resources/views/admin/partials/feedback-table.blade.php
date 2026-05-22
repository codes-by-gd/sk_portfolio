<div class="overflow-x-auto">
    <table class="table table-md w-full text-left">
        <thead class="bg-base-200 text-xs font-bold uppercase tracking-wider text-neutral/70 border-b border-base-300">
            <tr>
                <th class="py-4">Submitter Details</th>
                <th class="py-4">Feedback Content</th>
                <th class="py-4 text-center">Rating</th>
                <th class="py-4">Photos</th>
                <th class="py-4">{{ __('messages.admin.status') }}</th>
                <th class="py-4 text-center">{{ __('messages.admin.actions') }}</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-base-300 text-sm text-neutral">
            @forelse($feedbacks as $feedback)
                <tr class="hover:bg-base-100/50 transition-colors">
                    <!-- Submitter Details -->
                    <td class="py-4 space-y-1 vertical-align-top min-w-[200px]">
                        <div class="flex items-center gap-3">
                            <!-- Avatar Upload Form -->
                            <form action="{{ route('admin.feedback.avatar', $feedback) }}" method="POST" enctype="multipart/form-data" class="relative group shrink-0">
                                @csrf
                                <label class="cursor-pointer relative block w-11 h-11 rounded-full overflow-hidden border border-base-300 bg-base-200 shadow-sm" title="Upload Avatar">
                                    @if($feedback->avatar_path)
                                        <img src="{{ asset($feedback->avatar_path) }}" class="object-cover w-full h-full" alt="Avatar">
                                    @else
                                        <div class="w-full h-full bg-neutral/10 flex items-center justify-center text-neutral/50 font-heading font-extrabold text-xs uppercase">
                                            {{ substr($feedback->name, 0, 2) }}
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <i class="fa-solid fa-camera text-white text-xs"></i>
                                    </div>
                                    <input type="file" name="avatar" class="hidden" accept="image/*" onchange="this.form.submit()">
                                </label>
                            </form>
                            <div>
                                <p class="font-bold text-neutral leading-tight">{{ $feedback->name }}</p>
                                <p class="text-xs text-neutral/70 font-semibold mt-1"><i class="fa-solid fa-phone mr-1 opacity-50 text-[10px]"></i>{{ $feedback->mobile_number }}</p>
                                <p class="text-xs text-secondary font-bold uppercase tracking-wider mt-0.5"><i class="fa-solid fa-location-dot mr-1 opacity-50 text-[10px]"></i>{{ $feedback->area }}</p>
                            </div>
                        </div>
                    </td>

                    <!-- Feedback Content -->
                    <td class="py-4 max-w-sm vertical-align-top">
                        <p class="font-bold text-neutral mb-1 leading-snug">{{ $feedback->title }}</p>
                        <p class="text-xs text-neutral/80 line-clamp-3 leading-relaxed whitespace-pre-line">{{ $feedback->message }}</p>
                        <span class="text-[10px] text-neutral/40 font-bold block mt-1">{{ $feedback->created_at->format('M d, Y h:i A') }}</span>
                    </td>

                    <!-- Rating Stars -->
                    <td class="py-4 text-center vertical-align-top">
                        <div class="inline-flex text-warning text-xs gap-0.5 font-bold">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-{{ $i <= $feedback->rating ? 'solid' : 'regular' }} fa-star"></i>
                            @endfor
                        </div>
                    </td>

                    <!-- Uploaded/Captured Photos -->
                    <td class="py-4 vertical-align-top min-w-[120px]">
                        @if($feedback->images->isNotEmpty())
                            <div class="flex gap-1.5 flex-wrap">
                                @foreach($feedback->images as $img)
                                    <a href="{{ asset($img->image_path) }}" target="_blank" class="w-12 h-12 rounded-lg overflow-hidden border border-base-300 hover:scale-105 transition-transform duration-200 block bg-base-300">
                                        <img src="{{ asset($img->image_path) }}" class="object-cover w-full h-full" alt="Review Media">
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <span class="text-xs text-neutral/40 italic">No Media</span>
                        @endif
                    </td>

                    <!-- Status Badge -->
                    <td class="py-4 vertical-align-top">
                        @if($feedback->status === 'approved')
                            <span class="badge badge-success text-white font-bold text-xs">Approved</span>
                            @if($feedback->is_featured)
                                <span class="badge badge-warning text-[10px] uppercase font-bold text-white block mt-1 tracking-wider">Featured</span>
                            @endif
                        @elseif($feedback->status === 'rejected')
                            <span class="badge badge-error text-white font-bold text-xs">Rejected</span>
                        @else
                            <span class="badge badge-warning font-bold text-xs">Pending</span>
                        @endif
                    </td>

                    <!-- Actions row buttons -->
                    <td class="py-4 vertical-align-top text-center space-y-1.5 min-w-[180px]">
                        <div class="flex flex-wrap justify-center gap-1.5">
                            <!-- Approval Action Form -->
                            @if($feedback->status !== 'approved')
                                <form action="{{ route('admin.feedback.status', $feedback) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="btn btn-xs btn-success text-white rounded-lg px-2.5 font-bold">
                                        Approve
                                    </button>
                                </form>
                            @endif

                            <!-- Rejection Action Form -->
                            @if($feedback->status !== 'rejected')
                                <form action="{{ route('admin.feedback.status', $feedback) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="btn btn-xs btn-error text-white rounded-lg px-2.5 font-bold">
                                        Reject
                                    </button>
                                </form>
                            @endif

                            <!-- Feature Toggle Action Form -->
                            @if($feedback->status === 'approved')
                                <form action="{{ route('admin.feedback.featured', $feedback) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="btn btn-xs {{ $feedback->is_featured ? 'btn-neutral' : 'btn-warning text-white' }} rounded-lg px-2 font-bold">
                                        {{ $feedback->is_featured ? 'Unfeature' : 'Feature' }}
                                    </button>
                                </form>
                            @endif

                            <!-- Delete Action Form -->
                            <form action="{{ route('admin.feedback.destroy', $feedback) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this feedback permanent?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-outline btn-neutral rounded-lg px-2.5">
                                    <i class="fa-solid fa-trash-can text-red-500"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-12 text-neutral/50 font-medium italic">
                        No feedbacks found matching query criteria.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination block -->
@if($feedbacks->hasPages())
    <div class="p-4 border-t border-base-300 flex justify-center">
        {{ $feedbacks->links() }}
    </div>
@endif
