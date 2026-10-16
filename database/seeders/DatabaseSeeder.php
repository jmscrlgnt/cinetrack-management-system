<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@cinetrack.test'],
            [
                'name' => 'CineTrack Administrator',
                'password' => 'Admin@12345',
                'role' => 'admin',
            ]
        );

        $user = User::updateOrCreate(
            ['email' => 'user@cinetrack.test'],
            [
                'name' => 'CineTrack User',
                'password' => 'User@12345',
                'role' => 'user',
            ]
        );

        Movie::whereNull('user_id')->update(['user_id' => $admin->id]);

        if (Movie::count() === 0) {
            Movie::create([
                'user_id' => $user->id,
                'title' => 'Interstellar',
                'genre' => 'Science Fiction',
                'release_year' => 2014,
                'status' => 'Completed',
                'rating' => 9.5,
                'notes' => 'A favorite science-fiction film.',
                'is_favorite' => true,
            ]);

            Movie::create([
                'user_id' => $user->id,
                'title' => 'Inception',
                'genre' => 'Science Fiction',
                'release_year' => 2010,
                'status' => 'Watching',
                'rating' => 9.0,
                'notes' => 'Currently rewatching.',
                'is_favorite' => false,
            ]);

            Movie::create([
                'user_id' => $user->id,
                'title' => 'The Dark Knight',
                'genre' => 'Action',
                'release_year' => 2008,
                'status' => 'Plan to Watch',
                'rating' => null,
                'notes' => null,
                'is_favorite' => false,
            ]);
        }
    }
}
