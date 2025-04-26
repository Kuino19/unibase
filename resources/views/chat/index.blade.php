<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chat') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-black min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white">
                    <form method="GET" action="{{ route('chat.index') }}" class="mb-4">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search friends by name or email..." class="border rounded px-3 py-2 w-1/2 bg-gray-800 text-white placeholder-gray-400">
                        <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded">Search</button>
                    </form>
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($friends as $friend)
                            <div class="block p-4 bg-gray-800 rounded-lg hover:bg-gray-700">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 rounded-full bg-gray-600 flex items-center justify-center">
                                            <span class="text-xl font-bold text-white">
                                                {{ strtoupper(substr($friend->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-lg font-medium text-white flex items-center">
                                            <span class="inline-block w-3 h-3 rounded-full mr-2 align-middle {{ $friend->is_online ? 'bg-green-500' : 'bg-gray-400' }}" title="{{ $friend->is_online ? 'Online' : 'Offline' }}"></span>
                                            <span>{{ $friend->name }}</span>
                                            @if($friend->unread_count > 0)
                                                <span class="ml-2 inline-block bg-red-600 text-white text-xs px-2 py-0.5 rounded-full">{{ $friend->unread_count }}</span>
                                            @endif
                                        </p>
                                        <p class="text-sm text-gray-300">{{ $friend->email }}</p>
                                    </div>
                                    <div>
                                        <a href="{{ route('chat.show', $friend) }}" class="px-2 py-1 bg-blue-500 text-white rounded">Chat</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
