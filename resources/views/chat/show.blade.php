@php
    // Set default theme
    $theme = session('theme', 'light');
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Chat with') }} {{ $user->name }}
            </h2>
            <!-- <button id="toggle-dark-mode" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                Toggle Dark Mode
            </button> -->
            <a href="{{ route('chat.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 ml-2">
                Back to Users
            </a>
        </div>
    </x-slot>

    <div id="chat-theme-wrapper" class="py-12 min-h-screen bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div id="chat-theme-inner" class="bg-white text-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex flex-col h-[600px]">
                        <div class="flex-1 overflow-y-auto mb-4 space-y-4" id="messages-container">
                            @foreach($messages as $message)
                                <div class="flex {{ $message->sender_id === Auth::id() ? 'justify-end' : 'justify-start' }}">
                                    <div class="rounded-lg px-4 py-2 max-w-[70%] {{
                                        $message->sender_id === Auth::id()
                                            ? 'bg-yellow-400 text-gray-900' : 'bg-gray-200 text-gray-900'
                                    }}" data-sent="{{ $message->sender_id === Auth::id() ? '1' : '0' }}">
                                        <p class="text-sm font-semibold">{{ $message->message }}</p>
                                        <p class="text-xs mt-1 {{ $message->sender_id === Auth::id() ? 'text-gray-700' : 'text-gray-500' }}">
                                            {{ $message->created_at->format('M j, g:i a') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <form action="{{ route('chat.store', $user) }}" method="POST" class="mt-4" enctype="multipart/form-data">
                            @csrf
                            <div class="flex space-x-2 items-center">
                                <button type="button" id="emoji-picker-btn" class="text-2xl px-2 py-1 bg-gray-100 hover:bg-gray-200 rounded" title="Add emoji">😊</button>
                                <div id="emoji-picker-menu" class="absolute z-10 bg-white border rounded shadow p-2 mt-12 hidden" style="max-width: 220px;"></div>
                                <input type="text" 
                                       name="message" 
                                       class="flex-1 rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       placeholder="Type your message..."
                                       autocomplete="off"
                                       required>
                                <label for="chat-file-upload" class="cursor-pointer px-2 py-1 bg-gray-100 hover:bg-gray-200 rounded" title="Attach file">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.586-6.586a4 4 0 10-5.656-5.656l-8.486 8.486a6 6 0 108.486 8.486l6.586-6.586" /></svg>
                                </label>
                                <input id="chat-file-upload" type="file" name="file" class="hidden" accept="image/*,.pdf,.doc,.docx,.txt">
                                <button type="submit"
                                        id="send-btn"
                                        style="background: #000; color: #fff; border: 2px solid #000;"
                                        class="px-6 py-2 text-lg font-bold rounded-lg shadow-md transition-colors focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-opacity-50 disabled:opacity-50 disabled:cursor-not-allowed">
                                    Send
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/js/emoji-picker.js"></script>
    <script>
        // Dark mode logic
        function setDarkMode(enabled) {
            const wrapper = document.getElementById('chat-theme-wrapper');
            const inner = document.getElementById('chat-theme-inner');
            // Wrapper background
            wrapper.classList.toggle('bg-gray-900', enabled);
            wrapper.classList.toggle('bg-gray-100', !enabled);
            // Inner background/text
            inner.classList.toggle('bg-gray-800', enabled);
            inner.classList.toggle('text-white', enabled);
            inner.classList.toggle('bg-white', !enabled);
            inner.classList.toggle('text-gray-900', !enabled);
            // Messages
            document.querySelectorAll('[data-sent]').forEach(function(div) {
                if (div.getAttribute('data-sent') === '1') {
                    div.classList.toggle('bg-yellow-400', !enabled);
                    div.classList.toggle('text-gray-900', !enabled);
                    div.classList.toggle('bg-indigo-600', enabled);
                    div.classList.toggle('text-yellow-200', enabled);
                } else {
                    div.classList.toggle('bg-gray-200', !enabled);
                    div.classList.toggle('text-gray-900', !enabled);
                    div.classList.toggle('bg-gray-700', enabled);
                    div.classList.toggle('text-white', enabled);
                }
            });
        }
        document.getElementById('toggle-dark-mode').addEventListener('click', function() {
            const enabled = !document.getElementById('chat-theme-wrapper').classList.contains('bg-gray-900');
            setDarkMode(enabled);
            localStorage.setItem('chat-theme', enabled ? 'dark' : 'light');
        });
        // On load, set theme from localStorage
        window.addEventListener('DOMContentLoaded', function() {
            const theme = localStorage.getItem('chat-theme');
            setDarkMode(theme === 'dark');
        });

        // Enable/disable send button based on input
        const input = document.querySelector('input[name="message"]');
        const sendBtn = document.getElementById('send-btn');
        function toggleSendBtn() {
            sendBtn.disabled = !input.value.trim();
        }
        input.addEventListener('input', toggleSendBtn);
        toggleSendBtn();

        // Show file name on file select
        document.getElementById('chat-file-upload').addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                document.getElementById('send-btn').textContent = 'Send (' + e.target.files[0].name + ')';
            } else {
                document.getElementById('send-btn').textContent = 'Send';
            }
        });
    </script>

    @push('scripts')
    <script>
        // Scroll to bottom of messages container
        const messagesContainer = document.getElementById('messages-container');
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        // Mark messages as read
        fetch('{{ route('chat.read', $user) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        });
    </script>
    @endpush
</x-app-layout>
