<div id="global-loading-overlay"
    class="fixed inset-0 z-[99999] hidden items-center justify-center bg-slate-950/75 backdrop-blur-md transition-all duration-200 pointer-events-auto select-none"
    aria-hidden="true">
    <div class="flex flex-col items-center justify-center gap-4">
        {{-- High-Performance Dual-Ring Glowing Spinner --}}
        <div class="relative w-16 h-16 flex items-center justify-center">
            {{-- Outer glow track --}}
            <div class="absolute inset-0 rounded-full border-4 border-cyan-500/20"></div>
            {{-- Rotating gradient arc --}}
            <div class="w-16 h-16 rounded-full border-4 border-transparent border-t-cyan-400 border-r-blue-500 animate-spin"
                 style="animation-duration: 0.75s;"></div>
            {{-- Inner glowing core --}}
            <div class="absolute w-4 h-4 rounded-full bg-cyan-400 shadow-[0_0_16px_rgba(34,211,238,0.8)] animate-pulse"></div>
        </div>
        <p class="text-sm font-mono tracking-[0.25em] text-cyan-300 uppercase font-bold drop-shadow-[0_0_10px_rgba(34,211,238,0.5)]">
            Loading...
        </p>
    </div>
</div>

<script>
(function() {
    let overlayTimer = null;

    function showGlobalLoader() {
        if (overlayTimer) clearTimeout(overlayTimer);
        // Show after tiny 50ms delay to feel immediate without flicker
        overlayTimer = setTimeout(function() {
            const el = document.getElementById('global-loading-overlay');
            if (el) {
                el.classList.remove('hidden');
                el.classList.add('flex');
            }
        }, 50);
    }

    function hideGlobalLoader() {
        if (overlayTimer) {
            clearTimeout(overlayTimer);
            overlayTimer = null;
        }
        const el = document.getElementById('global-loading-overlay');
        if (el) {
            el.classList.add('hidden');
            el.classList.remove('flex');
        }
    }

    // Livewire SPA navigation
    document.addEventListener('livewire:navigating', showGlobalLoader);
    document.addEventListener('livewire:navigated', hideGlobalLoader);

    // Livewire AJAX requests / actions (wire:click, wire:submit, etc.)
    document.addEventListener('livewire:init', function() {
        if (typeof Livewire !== 'undefined') {
            Livewire.hook('request', function({ respond, fail }) {
                showGlobalLoader();
                respond(hideGlobalLoader);
                fail(hideGlobalLoader);
            });
        }
    });

    if (window.Livewire) {
        window.Livewire.hook('request', function({ respond, fail }) {
            showGlobalLoader();
            respond(hideGlobalLoader);
            fail(hideGlobalLoader);
        });
    }

    // Intercept clicks on links and buttons with data-loading or forms
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a[href], button');
        if (!link) return;
        const href = link.getAttribute('href');
        if (href && !href.startsWith('#') && !href.startsWith('javascript:')) {
            showGlobalLoader();
        }
    });

    window.addEventListener('beforeunload', function() {
        showGlobalLoader();
    });
})();
</script>
