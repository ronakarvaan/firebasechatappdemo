<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <a href="{{ route('chat.view') }}">
                {{ __('chat') }}</a>
        </h2>
    </x-slot>
    <div class="chat-container">
        {{-- @if(count($chats)==0)
        <p>There is no chat yet.</p>
        @endif
        @foreach($chats as $chat )
        @if($chat->sender_id === auth()->user()->id)
        <p class="chat chat-right">
            <b>{{$chat->sender_name}} :</b><br>
            {{$chat->message}}
        </p>
        @else
        <p class="chat chat-left">
            <b>{{$chat->sender_name}} :</b><br>
            {{$chat->message}}
        </p>
        @endif
        @endforeach --}}
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

</x-app-layout>