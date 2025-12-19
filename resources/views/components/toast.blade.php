@props(['width' => 'w-96'])

<div x-data="{
        notifications: [],
        add(type, title, message) {
            const id = Date.now() + Math.random()
            this.notifications.push({ id, type, title, message })
            setTimeout(() => {
                this.remove(id)
            }, 5000)
        },
        remove(id) {
            this.notifications = this.notifications.filter(n => n.id !== id)
        },
        init() {
            // Use a unique request identifier to ensure session messages are only processed once per request
            // This prevents the success message from showing on every Turbo navigation
            const requestId = '{{ uniqid('req_', true) }}';
            const $el = this.$el;
            const processedKey = 'toast_processed_' + requestId;

            // Check if we've already processed messages for this request
            if (!sessionStorage.getItem(processedKey)) {
                // Mark as processed
                sessionStorage.setItem(processedKey, 'true');

                // Clean up old processed flags (keep only the last 10)
                try {
                    const keys = Object.keys(sessionStorage).filter(k => k.startsWith('toast_processed_'));
                    if (keys.length > 10) {
                        keys.slice(0, keys.length - 10).forEach(k => sessionStorage.removeItem(k));
                    }
                } catch (e) {
                    // Ignore errors
                }

                // Session-based flash messages – ensure they are only shown once per request
                @if (session('success'))
                    this.add('success', 'Success', '{{ addslashes(session('success')) }}');
                    @php(session()->forget('success'))
                @endif

                @if (session('error'))
                    this.add('error', 'Error', '{{ addslashes(session('error')) }}');
                    @php(session()->forget('error'))
                @endif

                @if (session('status'))
                    this.add('info', 'Info', '{{ addslashes(session('status')) }}');
                    @php(session()->forget('status'))
                @endif

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        this.add('error', 'Error', '{{ addslashes($error) }}');
                    @endforeach
                @endif
            }
        }
    }" @notify.window="add($event.detail.type, $event.detail.title, $event.detail.message)"
    class="fixed top-4 right-4 z-50 flex flex-col gap-3 {{ $width }}">
    <template x-for="notification in notifications" :key="notification.id">
        <div x-data="{ show: false }" x-init="$nextTick(() => show = true)" x-show="show"
            x-transition:enter="transition ease-[cubic-bezier(0.16,1,0.3,1)] duration-500 transform"
            x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transition ease-in duration-300 transform"
            x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0"
            class="relative w-full rounded-lg bg-[#27272a] border border-[#3f3f46] p-4 shadow-xl flex gap-3 items-start">
            <!-- Icons -->
            <div class="shrink-0 pt-0.5">
                <!-- Success Icon -->
                <template x-if="notification.type === 'success'">
                    <div class="w-6 h-6 rounded-full border-2 border-[#22c55e] flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-[#22c55e]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </template>

                <!-- Error Icon -->
                <template x-if="notification.type === 'error'">
                    <div class="w-6 h-6 rounded-full border-2 border-[#ef4444] flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-[#ef4444]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </template>

                <!-- Info Icon -->
                <template x-if="notification.type === 'info'">
                    <div class="w-6 h-6 rounded-full border-2 border-[#3b82f6] flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-[#3b82f6]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </template>
            </div>

            <!-- Content -->
            <div class="flex-1 min-w-0 pt-0.5">
                <h3 class="text-white font-semibold text-sm leading-tight mb-1" x-text="notification.title"></h3>
                <p class="text-[#a1a1aa] text-xs leading-relaxed" x-text="notification.message"></p>
            </div>

            <!-- Close Button -->
            <button @click="remove(notification.id)"
                class="text-[#71717a] hover:text-white transition-colors shrink-0 -mt-1 -mr-1">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </template>
</div>
