<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->johnDoe()->create();

        $usersCount = max((int)$this->command->ask('How many users would you like ?',20),1);
        User::factory($usersCount)->create();
        $this->command->info('Created '.$usersCount.' users + Admin John Doe');
    }
}
