<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Notifications
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($notifications->count())
                        <ul class="divide-y divide-gray-200">
                            @foreach($notifications as $notification)
                                <li class="py-4 flex items-center justify-between">
                                    <div>
                                        @if(isset($notification->data['from_user_name']))
                                            <span class="font-bold">{{ $notification->data['from_user_name'] }}</span>
                                        @endif
                                        <span>
                                            {{ $notification->data['message'] ?? '' }}
                                        </span>
                                        @if(isset($notification->data['message']) && isset($notification->data['from_user_id']))
                                            @if(str_contains($notification->type, 'FriendRequest'))
                                                <a href="{{ route('chat.index') }}" class="ml-2 text-indigo-600 hover:underline">View</a>
                                            @elseif(str_contains($notification->type, 'NewChatMessage'))
                                                <a href="{{ route('chat.show', $notification->data['from_user_id']) }}" class="ml-2 text-indigo-600 hover:underline">Reply</a>
                                            @endif
                                        @endif
                                    </div>
                                    @if(is_null($notification->read_at))
                                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="ml-4 px-3 py-1 bg-green-500 text-white rounded">Mark as read</button>
                                        </form>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No notifications yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
