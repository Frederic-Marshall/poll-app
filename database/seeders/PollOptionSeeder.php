<?php

namespace Database\Seeders;

use App\Models\Poll;
use App\Models\PollOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PollOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $polls = Poll::all();

        foreach ($polls as $poll) {
            if ($poll->title === 'Favorite Programming Language') {
                foreach (['PHP', 'JavaScript', 'Python', 'Go'] as $text) {
                    PollOption::create([
                        'poll_id' => $poll->id,
                        'text' => $text,
                    ]);
                }
            }

            if ($poll->title === 'Best Frontend Framework') {
                foreach (['Vue.js', 'React', 'Angular', 'Svelte'] as $text) {
                    PollOption::create([
                        'poll_id' => $poll->id,
                        'text' => $text,
                    ]);
                }
            }

            if ($poll->title === 'Favorite Database') {
                foreach (['MySQL', 'PostgreSQL', 'MongoDB', 'SQLite'] as $text) {
                    PollOption::create([
                        'poll_id' => $poll->id,
                        'text' => $text,
                    ]);
                }
            }
        }
    }
}
