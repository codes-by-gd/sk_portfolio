<div class="overflow-x-auto">
    <table class="table table-md w-full text-left">
        <thead class="bg-base-200 text-xs font-bold uppercase tracking-wider text-base-content/70 border-b border-base-300">
            <tr>
                <th class="py-4">Submitter Details</th>
                <th class="py-4">Feedback Content</th>
                <th class="py-4 text-center">Rating</th>
                <th class="py-4">{{ __('messages.admin.status') }}</th>
                <th class="py-4 text-center">{{ __('messages.admin.actions') }}</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-base-300 text-sm text-base-content">
            @forelse($feedbacks as $feedback)
                <tr class="hover:bg-base-200/50 transition-colors">
                    <!-- Submitter Details -->
                    <td class="py-4 space-y-1 vertical-align-top min-w-[200px]">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-full overflow-hidden border border-base-300 bg-base-200 shrink-0 shadow-sm flex items-center justify-center">
                                <div class="w-full h-full bg-base-300 flex items-center justify-center text-base-content/50 font-heading font-extrabold text-xs uppercase">
                                    {{ substr($feedback->name, 0, 2) }}
                                </div>
                            </div>
                            <div>
                                <p class="font-bold text-base-content leading-tight">{{ $feedback->name }}</p>
                                <p class="text-xs text-base-content/70 font-semibold mt-1"><i class="fa-solid fa-phone mr-1 opacity-50 text-[10px]"></i>{{ $feedback->mobile_number }}</p>
                                <p class="text-xs text-secondary font-extrabold uppercase tracking-wider mt-0.5"><i class="fa-solid fa-location-dot mr-1 opacity-50 text-[10px]"></i>{{ $feedback->area }}</p>
                            </div>
                        </div>
                    </td>

                    <!-- Feedback Content -->
                    <td class="py-4 max-w-sm vertical-align-top">
                        <p class="text-xs text-base-content/85 line-clamp-3 leading-relaxed whitespace-pre-line">{{ $feedback->message }}</p>
                        <span class="text-[10px] text-base-content/40 font-bold block mt-1">{{ $feedback->created_at->format('M d, Y h:i A') }}</span>
                    </td>

                    <!-- Rating Stars -->
                    <td class="py-4 text-center vertical-align-top">
                        <div class="inline-flex text-warning text-xs gap-0.5 font-bold">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-{{ $i <= $feedback->rating ? 'solid' : 'regular' }} fa-star"></i>
                            @endfor
                        </div>
                    </td>

                    <!-- Status Badge -->
                    <td class="py-4 vertical-align-top">
                        <div class="flex flex-col gap-1.5 items-start">
                            @if($feedback->status === 'approved')
                                <div class="badge badge-success badge-outline font-extrabold text-[11px] gap-1.5 py-3 px-3 shadow-sm select-none">
                                    <i class="fa-solid fa-circle-check text-xs"></i> Approved
                                </div>
                            @elseif($feedback->status === 'rejected')
                                <div class="badge badge-error badge-outline font-extrabold text-[11px] gap-1.5 py-3 px-3 shadow-sm select-none">
                                    <i class="fa-solid fa-circle-xmark text-xs"></i> Rejected
                                </div>
                            @else
                                <div class="badge badge-warning badge-outline font-extrabold text-[11px] gap-1.5 py-3 px-3 shadow-sm select-none">
                                    <i class="fa-solid fa-circle-notch fa-spin text-xs"></i> Pending
                                </div>
                            @endif
                            @if($feedback->is_featured)
                                <div class="badge badge-primary badge-outline font-extrabold text-[10px] uppercase tracking-wider gap-1.5 py-2.5 px-2.5 shadow-sm select-none">
                                    <i class="fa-solid fa-star text-xs text-primary"></i> Featured
                                </div>
                            @endif
                        </div>
                    </td>

                    <!-- Actions row buttons -->
                    <td class="py-4 vertical-align-top text-center min-w-[200px]">
                        <div class="flex items-center justify-center gap-2">
                            <!-- Approve Action -->
                            @if($feedback->status !== 'approved')
                                <form action="{{ route('admin.feedback.status', $feedback) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="btn btn-sm btn-square btn-soft btn-success tooltip tooltip-top" data-tip="Approve Feedback">
                                        <i class="fa-solid fa-check text-xs"></i>
                                    </button>
                                </form>
                            @endif

                            <!-- Reject Action -->
                            @if($feedback->status !== 'rejected')
                                <form action="{{ route('admin.feedback.status', $feedback) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="btn btn-sm btn-square btn-soft btn-error tooltip tooltip-top" data-tip="Reject Feedback">
                                        <i class="fa-solid fa-xmark text-xs"></i>
                                    </button>
                                </form>
                            @endif

                            <!-- Feature Action -->
                            @if($feedback->status === 'approved')
                                <form action="{{ route('admin.feedback.featured', $feedback) }}" method="POST" class="inline">
                                    @csrf
                                    @if($feedback->is_featured)
                                        <button type="submit" class="btn btn-sm btn-square btn-warning tooltip tooltip-top" data-tip="Unfeature Feedback">
                                            <i class="fa-solid fa-star text-xs"></i>
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-sm btn-square btn-soft btn-warning tooltip tooltip-top" data-tip="Feature Feedback">
                                            <i class="fa-regular fa-star text-xs"></i>
                                        </button>
                                    @endif
                                </form>
                            @endif

                            <!-- Edit Action -->
                            <button type="button" 
                                class="btn btn-sm btn-square btn-soft btn-info tooltip tooltip-top edit-feedback-btn"
                                data-tip="Edit Feedback"
                                data-id="{{ $feedback->id }}"
                                data-name="{{ $feedback->name }}"
                                data-mobile="{{ $feedback->mobile_number }}"
                                data-area="{{ $feedback->area }}"
                                data-message="{{ $feedback->message }}"
                                data-rating="{{ $feedback->rating }}"
                                data-status="{{ $feedback->status }}">
                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                            </button>

                            <!-- Delete Action -->
                            <form action="{{ route('admin.feedback.destroy', $feedback) }}" method="POST" class="inline" onsubmit="return confirm('Delete this feedback permanently?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-square btn-soft btn-error tooltip tooltip-top" data-tip="Delete Permanently">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-12 text-base-content/50 font-medium italic">
                        No feedbacks found matching query criteria.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Proper Pagination block -->
@if($feedbacks->hasPages())
    <div class="p-4 border-t border-base-300 flex justify-center items-center">
        <div class="join shadow-sm">
            {{-- Previous Page Link --}}
            @if ($feedbacks->onFirstPage())
                <button class="join-item btn btn-xs sm:btn-sm btn-outline border-base-300 text-base-content/40 cursor-not-allowed" disabled>
                    <i class="fa-solid fa-chevron-left text-[10px]"></i>
                </button>
            @else
                <a href="{{ $feedbacks->previousPageUrl() }}" class="join-item btn btn-xs sm:btn-sm btn-outline border-base-300 text-base-content hover:bg-primary hover:text-white hover:border-primary transition-all">
                    <i class="fa-solid fa-chevron-left text-[10px]"></i>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($feedbacks->getUrlRange(1, $feedbacks->lastPage()) as $page => $url)
                @if ($page == $feedbacks->currentPage())
                    <button class="join-item btn btn-xs sm:btn-sm btn-primary text-white font-extrabold">
                        {{ $page }}
                    </button>
                @else
                    <a href="{{ $url }}" class="join-item btn btn-xs sm:btn-sm btn-outline border-base-300 text-base-content hover:bg-primary hover:text-white hover:border-primary transition-all">
                        {{ $page }}
                    </a>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($feedbacks->hasMorePages())
                <a href="{{ $feedbacks->nextPageUrl() }}" class="join-item btn btn-xs sm:btn-sm btn-outline border-base-300 text-base-content hover:bg-primary hover:text-white hover:border-primary transition-all">
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </a>
            @else
                <button class="join-item btn btn-xs sm:btn-sm btn-outline border-base-300 text-base-content/40 cursor-not-allowed" disabled>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </button>
            @endif
        </div>
    </div>
@endif
