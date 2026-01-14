<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Board;
use App\Models\BoardList;
use App\Models\Card;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create 2 users
        $user1 = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ]);

        $user2 = User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create boards for User 1
        $board1 = Board::create([
            'title' => 'Project Alpha',
            'description' => 'Main project board',
            'user_id' => $user1->id,
        ]);

        $board2 = Board::create([
            'title' => 'Personal Tasks',
            'description' => 'My daily tasks',
            'user_id' => $user1->id,
        ]);

        // Create lists for Board 1
        $todoList = BoardList::create([
            'board_id' => $board1->id,
            'title' => 'To Do',
            'position' => 0,
        ]);

        $doingList = BoardList::create([
            'board_id' => $board1->id,
            'title' => 'In Progress',
            'position' => 1,
        ]);

        $doneList = BoardList::create([
            'board_id' => $board1->id,
            'title' => 'Done',
            'position' => 2,
        ]);

        // Create cards for To Do list
        Card::create([
            'board_list_id' => $todoList->id,
            'title' => 'Design homepage',
            'description' => 'Create mockups for the new homepage',
            'position' => 0,
            'due_date' => now()->addDays(5),
        ]);

        Card::create([
            'board_list_id' => $todoList->id,
            'title' => 'Write documentation',
            'description' => 'Document API endpoints',
            'position' => 1,
            'due_date' => now()->addDays(7),
        ]);

        // Create cards for In Progress list
        Card::create([
            'board_list_id' => $doingList->id,
            'title' => 'Build authentication',
            'description' => 'Implement login and registration',
            'position' => 2,
            'due_date' => now()->addDays(3),
        ]);

        // Create cards for Done list
        Card::create([
            'board_list_id' => $doneList->id,
            'title' => 'Setup database',
            'description' => 'Configure PostgreSQL and migrations',
            'position' => 3,
            'due_date' => now()->subDays(2),
        ]);

        Card::create([
            'board_list_id' => $doneList->id,
            'title' => 'Initialize repository',
            'description' => 'Setup Git and initial commit',
            'position' => 4,
            'due_date' => now()->subDays(5),
        ]);

        // Create board for User 2
        $board3 = Board::create([
            'title' => 'Marketing Campaign',
            'description' => 'Q1 marketing initiatives',
            'user_id' => $user2->id,
        ]);

        // Create lists for Board 3
        $ideasList = BoardList::create([
            'board_id' => $board3->id,
            'title' => 'Ideas',
            'position' => 0,
        ]);

        // Create cards
        Card::create([
            'board_list_id' => $ideasList->id,
            'title' => 'Social media strategy',
            'description' => 'Plan Instagram and Twitter campaigns',
            'position' => 0,
        ]);
    }
}