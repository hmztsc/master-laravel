<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        if($this->command->confirm('Do you want to refresh the database ?',true)){
            $this->command->call('migrate:refresh');
            $this->command->info('Database was refreshed.');
        }

        $seeders = [
            'UsersTableSeeder' => UsersTableSeeder::class,
            'BlogPostsTableSeeder' => BlogPostsTableSeeder::class,
            'CommentsTableSeeder' => CommentsTableSeeder::class,
        ];

        if($this->command->confirm('Do you want to seed them all ?',true)){
            $this->call($seeders);
        } else {
            $this->command->info(implode(PHP_EOL,array_keys($seeders)));
            $seeder = $this->command->ask('Which seeder will you use ?');
            $this->call($seeders[$seeder]);
        }

        $this->command->info('Database was seeded.');
    }
}
