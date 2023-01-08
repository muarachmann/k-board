<?php

namespace Database\Seeders;

use App\Models\BasicAccessToken;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class BasicAccessTokenTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Create sample user
        if (!BasicAccessToken::count()) {
            $this->command->info('Adding basic access tokens tables');
            $this->truncateTokenTable();
            BasicAccessToken::create([
                'token' => 'oQ6jaEuMTZRM7Bs0U3d391AtmEbuD89kkXyFUcsuAt8Cu'
            ]);
        }
    }

    /**
     * Truncates the users table
     * @return void
     */
    public function truncateTokenTable(): void
    {
        Schema::disableForeignKeyConstraints();
        BasicAccessToken::truncate();
        Schema::enableForeignKeyConstraints();
    }
}
