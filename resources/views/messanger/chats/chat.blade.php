<div x-data='chatWindow(@json($chat->messages), {{ $chat }})' class="flex flex-col h-full">
    <div class="flex items-center p-4 border-b border-gray-700 bg-gray-800 shadow-md z-10">
        <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-lg font-bold mr-3"></div>

        <div class="flex flex-col">
            <h2 class="font-semibold text-lg leading-tight" x-text="getInterlocutorName()"></h2>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto mb-4" x-ref="messagesContainer">
        <template x-for="message in messages" :key="message.id">
            <div
                class="flex w-full mb-2"
                :class="message.sender_id === {{ auth()->id() }} ? 'justify-end' : 'justify-start'">

                <div class="px-4 py-2 rounded-lg max-w-[80%] break-words text-white shadow-sm relative"
                     :class="[
                         message.sender_id === {{ auth()->id() }}
                            ? 'bg-blue-600 rounded-tr-none'
                            : 'bg-gray-600 rounded-tl-none'
                     ]">

                    <div class="text-sm leading-relaxed" x-text="message.body"></div>

                    <div class="text-[10px] text-white/70 text-right mt-1 select-none"
                         x-text="new Date(message.created_at).toLocaleTimeString()">
                    </div>
                </div>
            </div>
        </template>
    </div>

    <div class="flex">
        <input
            type="text"
            placeholder="Написать..."
            class="flex-15 p-2 rounded-l-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
            x-model="newMessage"
            @keyup.enter="sendMessage()"
        >
        <button
            @click="sendMessage()"
            class="flex-1 p-2 rounded bg-gray-400 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
            Send
        </button>
    </div>
</div>

<script>
    window.authUserId = {{ auth()->id() }};
</script>
