@if($approvedFeedbacks->isEmpty())
    <div class="bg-[#FFFDF8] border border-base-300 rounded-2xl p-8 text-center text-neutral/50 font-medium">
        <i class="fa-solid fa-comments text-3xl mb-2 text-neutral/30"></i>
        <p class="text-sm">No testimonials approved yet. Be the first to share your feedback!</p>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($approvedFeedbacks as $fb)
            <div class="bg-[#FFFDF8] border border-base-300 rounded-2xl p-6 shadow-sm flex flex-col justify-between space-y-4 hover:shadow-md transition-all duration-300">
                <div class="space-y-3">
                    <!-- Top: Submitter Details -->
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full overflow-hidden border border-base-300 bg-base-200 shrink-0 shadow-xs">
                                @if($fb->avatar_path)
                                    <img src="{{ asset($fb->avatar_path) }}" class="object-cover w-full h-full" alt="{{ $fb->name }}">
                                @else
                                    <div class="w-full h-full bg-neutral/10 flex items-center justify-center text-neutral/50 font-heading font-extrabold text-xs uppercase">
                                        {{ substr($fb->name, 0, 2) }}
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-bold text-neutral text-sm leading-snug">{{ $fb->name }}</h4>
                                <p class="text-[10px] text-neutral/50 font-semibold uppercase tracking-wider">{{ $fb->area }}</p>
                            </div>
                        </div>
                        <span class="text-[10px] text-neutral/40 font-medium">{{ $fb->created_at->diffForHumans() }}</span>
                    </div>

                    <!-- Stars Rating -->
                    <div class="flex text-warning text-xs gap-0.5">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fa-{{ $i <= $fb->rating ? 'solid' : 'regular' }} fa-star"></i>
                        @endfor
                    </div>

                    <!-- Feedback Title and Content -->
                    <div class="space-y-1">
                        <h5 class="font-bold text-neutral text-sm leading-snug">{{ $fb->title }}</h5>
                        <p class="text-neutral/70 text-xs sm:text-sm leading-relaxed whitespace-pre-line">
                            "{!! nl2br(e($fb->message)) !!}"
                        </p>
                    </div>
                </div>

                <!-- Media Uploads if any -->
                @if($fb->images->isNotEmpty())
                    <div class="flex gap-2 flex-wrap pt-2 border-t border-base-200">
                        @foreach($fb->images as $img)
                            <a href="{{ asset($img->image_path) }}" target="_blank" class="w-12 h-12 sm:w-16 sm:h-16 rounded-xl overflow-hidden border border-base-300 hover:scale-105 transition-transform duration-200 block bg-base-300">
                                <img src="{{ asset($img->image_path) }}" class="object-cover w-full h-full" alt="Citizen Review Image">
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Custom Premium daisyUI Pagination -->
    @if($approvedFeedbacks->hasPages())
        <div class="flex justify-center pt-8">
            <div class="join border border-base-300 bg-[#FFFDF8] shadow-sm rounded-xl overflow-hidden">
                {{-- Previous Page Link --}}
                @if($approvedFeedbacks->onFirstPage())
                    <button class="join-item btn btn-md btn-ghost text-neutral/30 cursor-not-allowed" disabled>«</button>
                @else
                    <a href="{{ $approvedFeedbacks->previousPageUrl() }}" class="join-item btn btn-md btn-ghost text-neutral hover:bg-primary hover:text-white transition-colors">«</a>
                @endif

                {{-- Page Links --}}
                @foreach(range(1, $approvedFeedbacks->lastPage()) as $i)
                    @if($i == $approvedFeedbacks->currentPage())
                        <button class="join-item btn btn-md btn-primary text-white font-bold">{{ $i }}</button>
                    @else
                        <a href="{{ $approvedFeedbacks->url($i) }}" class="join-item btn btn-md btn-ghost text-neutral hover:bg-primary hover:text-white transition-colors">{{ $i }}</a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if($approvedFeedbacks->hasMorePages())
                    <a href="{{ $approvedFeedbacks->nextPageUrl() }}" class="join-item btn btn-md btn-ghost text-neutral hover:bg-primary hover:text-white transition-colors">»</a>
                @else
                    <button class="join-item btn btn-md btn-ghost text-neutral/30 cursor-not-allowed" disabled>»</button>
                @endif
            </div>
        </div>
    @endif
@endif
