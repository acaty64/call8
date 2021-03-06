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
        $this->call(TypeSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(OfficeSeeder::class);
        $this->call(AccessSeeder::class);
        $this->call(WindowSeeder::class);
        if(env('APP_DEBUG'))
        {
            $this->call(LinkSeeder::class);
            $this->call(CallSeeder::class);
            $this->call(TraceSeeder::class);
            $this->call(ScheduleSeeder::class);
            $this->call(CommentSeeder::class);
        }
    }
}
