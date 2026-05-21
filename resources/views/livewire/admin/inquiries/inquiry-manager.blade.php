<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-white">Inquiries</h2>
            <p class="text-sm text-slate-400 mt-1">Messages submitted from the public portfolio</p>
        </div>

        <div class="rounded-lg border border-cyan-400/20 bg-cyan-400/10 px-4 py-2 text-cyan-300 font-mono text-sm">
            {{ $unreadCount }} unread
        </div>
    </div>

    <div class="flex flex-wrap gap-2">
        @foreach (['active' => 'Active', 'unread' => 'Unread', 'archived' => 'Archived', 'all' => 'All'] as $value => $label)
            <button wire:click="$set('filter', '{{ $value }}')"
                class="px-3 py-1.5 rounded-lg border text-xs font-mono transition {{ $filter === $value ? 'border-cyan-400 bg-cyan-400/10 text-cyan-300' : 'border-slate-700 text-slate-400 hover:border-cyan-400 hover:text-cyan-300' }}">
                {{ $label }}
            </button>
        @endforeach
    </div>

    @if ($inquiries->isEmpty())
        <div class="card p-16 text-center">
            <p class="text-sm text-slate-400">No inquiries in this view.</p>
        </div>
    @else
        <div class="grid xl:grid-cols-[380px_1fr] gap-6">
            <div class="space-y-3">
                @foreach ($inquiries as $inquiry)
                    <button wire:click="selectInquiry({{ $inquiry->id }})"
                        class="w-full text-left rounded-lg border p-4 transition {{ $selected?->id === $inquiry->id ? 'border-cyan-400 bg-cyan-400/10' : 'border-slate-700 bg-[#080a14] hover:border-slate-500' }}">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-100 truncate">{{ $inquiry->name }}</p>
                                <p class="text-xs text-slate-500 truncate mt-1">{{ $inquiry->email }}</p>
                            </div>
                            <span class="text-[10px] uppercase tracking-widest font-mono rounded-full px-2 py-1
                                @if ($inquiry->status === 'unread') bg-cyan-400/10 text-cyan-300
                                @elseif ($inquiry->status === 'archived') bg-slate-700/50 text-slate-400
                                @else bg-green-400/10 text-green-300 @endif">
                                {{ $inquiry->status }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-400 mt-3 line-clamp-2">{{ $inquiry->message }}</p>
                        <p class="text-[11px] text-slate-600 mt-3 font-mono">{{ $inquiry->created_at->diffForHumans() }}</p>
                    </button>
                @endforeach
            </div>

            <div class="card p-8 min-h-[420px]">
                @if ($selected)
                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                        <div>
                            <p class="text-xs font-mono uppercase tracking-widest text-cyan-400">Message from</p>
                            <h3 class="text-2xl font-bold text-white mt-2">{{ $selected->name }}</h3>
                            <a href="mailto:{{ $selected->email }}" class="text-sm text-cyan-400 hover:text-cyan-300 transition mt-1 inline-block">
                                {{ $selected->email }}
                            </a>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            @if ($selected->status !== 'read')
                                <button wire:click="markRead({{ $selected->id }})" class="btn-ghost px-3 py-1.5 text-xs">Mark Read</button>
                            @endif
                            @if ($selected->status !== 'unread')
                                <button wire:click="markUnread({{ $selected->id }})" class="btn-ghost px-3 py-1.5 text-xs">Mark Unread</button>
                            @endif
                            @if ($selected->status !== 'archived')
                                <button wire:click="archive({{ $selected->id }})" class="btn-delete px-3 py-1.5 text-xs">Archive</button>
                            @endif
                        </div>
                    </div>

                    <div class="mt-8 rounded-lg border border-slate-700 bg-[#080a14] p-5">
                        <p class="whitespace-pre-line text-slate-300 leading-relaxed">{{ $selected->message }}</p>
                    </div>

                    <div class="grid sm:grid-cols-3 gap-4 mt-6">
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-widest font-mono">Received</p>
                            <p class="text-sm text-slate-300 mt-1">{{ $selected->created_at->format('M d, Y g:i A') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-widest font-mono">Read</p>
                            <p class="text-sm text-slate-300 mt-1">{{ $selected->read_at?->format('M d, Y g:i A') ?? 'Not yet' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-widest font-mono">Archived</p>
                            <p class="text-sm text-slate-300 mt-1">{{ $selected->archived_at?->format('M d, Y g:i A') ?? 'No' }}</p>
                        </div>
                    </div>
                @else
                    <div class="h-full min-h-[320px] flex items-center justify-center text-slate-500 text-sm">
                        Select an inquiry to read it.
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
