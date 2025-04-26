<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Friends') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-white min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="GET" action="{{ route('friends.index') }}" class="mb-4">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users by name or email..." class="border rounded px-3 py-2 w-1/2">
                        <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded">Search</button>
                    </form>
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($users as $user)
                            <div class="block p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center">
                                            <span class="text-xl font-bold text-gray-600">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-lg font-medium text-gray-900">{{ $user->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                    </div>
                                    <div>
                                        @php
                                            $friendship = Auth::user()->friendships()->where('friend_id', $user->id)->first() ??
                                                Auth::user()->friendsOf()->where('user_id', $user->id)->first();
                                        @endphp
                                        @if($friendship)
                                            @if($friendship->status === 'pending' && $friendship->user_id === Auth::id())
                                                <span class="text-yellow-500">Request Sent</span>
                                            @elseif($friendship->status === 'pending' && $friendship->friend_id === Auth::id())
                                                <form action="{{ route('friends.accept', $friendship) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="px-2 py-1 bg-green-500 text-black rounded">Accept</button>
                                                </form>
                                            @elseif($friendship->status === 'accepted')
                                                <form action="{{ route('friends.remove', $user) }}" method="POST" class="inline ml-2">
                                                    @csrf
                                                    <button type="submit" class="px-2 py-1 bg-red-500 text-black rounded">Remove</button>
                                                </form>
                                            @endif
                                        @else
                                            <form action="{{ route('friends.add', $user) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="px-2 py-1 bg-pink-600 hover:bg-pink-700 text-black rounded">Add Friend</button>
                                            </form>
                                        @endif
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
