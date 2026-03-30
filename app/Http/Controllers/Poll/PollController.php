<?php

namespace App\Http\Controllers\Poll;

use App\Http\Controllers\Controller;
use App\Http\Requests\Poll\PollVoteRequest;
use App\Jobs\ExportPollJob;
use App\Models\Poll;
use App\Models\PollOption;
use App\Models\Vote;

class PollController extends Controller
{
    public function index()
    {
        $polls = Poll::where('status', 'active')->get();

        return view('polls.index', compact('polls'));
    }

    public function show(Poll $poll)
    {
        $poll->load('options');
        $userVote = null;

        if (auth()->check()) {
            $userVote = $poll->votes()->where('user_id', auth()->id())->first();
        }

        $options = PollOption::votesCalculate($poll);

        return view('polls.show', [
            'poll' => $poll,
            'options' => $options,
            'userVote' => $userVote,
            'hasVoted' => (bool) $userVote
        ]);
    }

    public function vote(PollVoteRequest $request, Poll $poll)
    {
        $request->validated();

        Vote::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'poll_id' => $poll->id
            ],
            [
                'option_id' => $request->input('option_id'),
            ]
        );

        $options = PollOption::votesCalculate($poll);

        return response()->json(['options' => $options]);
    }

    public function export()
    {
        $polls = Poll::with('options')->get();
        ExportPollJob::dispatch($polls)->onQueue('exports');

        return back()->with('status', 'Файл формируется!');
    }
}
