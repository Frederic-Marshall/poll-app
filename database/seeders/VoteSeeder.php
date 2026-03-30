<?php

namespace Database\Seeders;

use App\Models\Poll;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('nickname', 'admin')->first();
        $user = User::where('nickname', 'user')->first();
        $polls = Poll::all();

        foreach ($polls as $poll) {
            $options = $poll->options()->get();

            Vote::create([
                'poll_id' => $poll->id,
                'option_id' => $options->first()->id,
                'user_id' => $admin->id,
            ]);

            if ($options->count() > 1) {
                Vote::create([
                    'poll_id' => $poll->id,
                    'option_id' => $options[1]->id,
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}
