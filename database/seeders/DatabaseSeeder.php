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
        $this->call(UsersSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(CallSeeder::class);
        $this->call(WindowSeeder::class);
        $this->call(TraceSeeder::class);
        $this->call(OfficeSeeder::class);
        $this->call(ScheduleSeeder::class);
    }
}
