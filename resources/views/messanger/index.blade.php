@extends('layout.app')

@section('content')
    <div class="flex h-screen bg-gray-900 text-white">
        <div
            x-data='chatList(@json($chats))'
            x-init="init()"
            class="w-80 bg-gray-800 p-4 rounded-r-xl overflow-y-auto">

            <h1 class="text-xl font-bold mb-4">Чаты</h1>

            <template x-if="chats.length === 0">
                <p class="text-gray-400 text-center mt-4">Чатов пока нет.</p>
            </template>

            <template x-for="chat in chats" :key="chat.id">
                <button
                    @click="$dispatch('chat-selected', chat)"
                    class="w-full text-left block p-3 mb-2 rounded-lg hover:bg-gray-700 transition flex justify-between cursor-pointer">
                    <div>
                        <p class="font-semibold" x-text="chat.type === 'private' ? chat.users.find(u => u.id !== {{ auth()->id() }}).name : chat.name"></p>
                        <p class="text-gray-400 text-sm truncate" x-text="chat.lastMessage ? chat.lastMessage.body : 'Нет сообщений'"></p>
                    </div>
                    <div class="text-gray-500 text-xs" x-text="chat.updated_at ? new Date(chat.updated_at).toLocaleTimeString() : ''"></div>
                </button>
            </template>
        </div>

        <div class="flex-1 bg-gray-900 p-4 overflow-y-auto rounded-l-xl" id="chat-window">
            @yield('chat')
        </div>

    </div>

    <script>
        function chatList(startChats) {
            return {
                chats: startChats,
                init() {
                    Echo.channel(`user.{{ auth()->id() }}`)
                        .listen('MessageSent', (e) => {
                            let chatIndex = this.chats.findIndex(c => c.id === e.message.chat_id);
                            if (chatIndex !== -1) {
                                this.chats[chatIndex].lastMessage = e.message;
                                this.chats[chatIndex].updated_at = e.message.created_at;

                                let chat = this.chats.splice(chatIndex, 1)[0];
                                this.chats.unshift(chat);
                            } else {
                                this.chats.unshift(e.chat);
                            }
                        });

                    // Слушаем выбор чата из списка
                    window.addEventListener('chat-selected', (event) => {
                        const chat = event.detail;
                        fetch(`/chats/${chat.id}`)
                            .then(res => res.text())
                            .then(html => {
                                document.getElementById('chat-window').innerHTML = html;
                            });
                    });
                }
            }
        }
    </script>
@endsection
