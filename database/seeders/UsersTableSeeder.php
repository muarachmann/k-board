<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Create sample user
        if (!User::count()) {
            $this->command->info('Truncating Kanban board Users\'s tables');
            $this->truncateUsersTable();
            User::create([
                'name' => 'Mua Rachmann',
                'email' => 'muarachmann@gmail.com',
                'password' => Hash::make('kanban-test')
            ]);
        }
    }

    /**
     * Truncates the users table
     * @return void
     */
    public function truncateUsersTable(): void
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();
    }
}
