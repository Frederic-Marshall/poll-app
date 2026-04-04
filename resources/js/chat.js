window.csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

window.chatWindow = function(initMessages, chat) {
    return {
        messages: initMessages || [],
        newMessage: '',
        chat: chat,

        init() {
            this.scrollBottom();
            Echo.private(`chat.${this.chat.id}`)
                .listen('MessageSent', (e) => {
                    if(e && e.message) {
                        console.log(e)
                        this.addMessage(e.message);
                    }
                })
        },

        sendMessage() {
            if (!this.newMessage.trim()) return;

            const payload = {
                body: this.newMessage,
                chat_id: this.chat.id
            };

            fetch(`/send`, {
                method: 'POST',
                credentials: 'include',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': window.csrf
                },
                body: JSON.stringify(payload)
            }).then(response => {
                if (response.ok) {
                    return response.json();
                }
            }).then(data => {
                this.newMessage = '';

                // Нет необходимости, т.к. создает дублированный UX
                //this.addMessage(data);

                this.scrollBottom();
            });
        },

        addMessage(message) {
            const exists = this.messages.find(m => m.id === message.id);
            if (!exists) {
                this.messages.push(message);
                this.scrollBottom();
            }
        },

        scrollBottom() {
            this.$nextTick(() => {
                if (this.$refs.messagesContainer) {
                    this.$refs.messagesContainer.scrollTop = this.$refs.messagesContainer.scrollHeight;
                }
            });
        },

        getInterlocutorName() {
            console.log(this.chat)
            if (this.chat.users.length === 2) {
                const interlocutor = this.chat.users.find(u => u.id !== window.authUserId);
                return interlocutor ? interlocutor.name : 'Неизвестный';
            }

            return this.chat.title;
        },
    }
}
