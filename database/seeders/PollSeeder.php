<?php

namespace Database\Seeders;

use App\Models\Poll;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('nickname', 'admin')->first();

        Poll::create([
            'user_id' => $admin->id,
            'title' => 'Favorite Programming Language',
            'description' => 'Vote for your favorite programming language',
            'status' => 'active',
            'join_code' => Str::upper(Str::random(6)),
        ]);

        Poll::create([
            'user_id' => $admin->id,
            'title' => 'Best Frontend Framework',
            'description' => 'Choose the framework you like most',
            'status' => 'active',
            'join_code' => Str::upper(Str::random(6)),
        ]);
    }
}
