<?php
namespace Database\Seeders;

use App\Models\Access;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AccessSeeder extends Seeder
{
    public function run()
    {
        Access::create([
            'user_id' => 1,
            'type_id' => 1,
        ]);

        if(env('APP_DEBUG'))
        {
            Access::create([
                'user_id' => 2,
                'type_id' => 2,
            ]);

            Access::create([
                'user_id' => 3,
                'type_id' => 3,
            ]);
        }
    }
}
