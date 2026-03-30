@extends('layout.app')

@section('title', 'Опрос ' . $poll->title)

@section('content')
    <div class="max-w-2xl mx-auto mt-6 bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-2">{{ $poll->title }}</h1>
        <p class="text-gray-600 mb-6">{{ $poll->description }}</p>

        <div x-data='pollVoting(@json($options), @json(route("polls.vote", $poll)), {{ $hasVoted ? "true" : "false" }})' class="space-y-4">
            <template x-for="option in options" :key="option.id">
                <div>
                    <button
                        @click="vote(option.id)"
                        :disabled="hasVoted"
                        :class="hasVoted ? 'bg-gray-100 text-gray-600 cursor-not-allowed' : 'bg-gray-200 hover:bg-gray-300 text-gray-800 cursor-pointer'"
                        class="w-full rounded-md p-3 flex items-center justify-between transition relative overflow-hidden"
                    >
                        <div class="flex items-center gap-3">
                            <template x-if="option.image_url">
                                <img :src="option.image_url" alt="" class="w-12 h-12 object-cover rounded-md flex-shrink-0">
                            </template>
                            <span x-text="option.text" class="font-medium"></span>
                        </div>

                        <span x-show="hasVoted" x-text="option.ratio + '%'" class="ml-2"></span>

                        <div x-show="hasVoted" class="absolute left-0 top-0 h-full bg-blue-400 opacity-30 z-0"
                             :style="'width: ' + option.ratio + '%;'"></div>
                    </button>
                </div>
            </template>
        </div>
    </div>

    <script>
        function sharePoll(url) {
            return {
                copied: false,
                pollUrl: url,
                copyLink() {
                    navigator.clipboard.writeText(this.pollUrl)
                        .then(() => {
                            this.copied = true;
                            setTimeout(() => this.copied = false, 2000);
                        })
                        .catch(err => console.error('Ошибка копирования: ', err));
                }
            }
        }

        function pollVoting(options, voteUrl, hasVoted) {
            return {
                options: options.map(o => ({ ...o })),
                hasVoted: hasVoted,
                vote(optionId) {
                    if (this.hasVoted) return;

                    fetch(voteUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ option_id: optionId }),
                        credentials: 'same-origin'
                    })
                        .then(res => res.json())
                        .then(data => {
                            this.options = data.options.map(o => ({ ...o }));
                            this.hasVoted = true;
                        })
                        .catch(err => console.error('Ошибка голосования: ', err));
                }
            }
        }
    </script>
@endsection
