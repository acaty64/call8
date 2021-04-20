<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Call;

class CallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		Call::create([
			'number' => 1,
			'user_id' => 4,
			'status_id' => 4,
		]);

		Call::create([
			'number' => 2,
			'user_id' => 5,
			'status_id' => 4,
		]);

		Call::create([
			'number' => 3,
			'user_id' => 6,
			'status_id' => 5,
		]);

    }
}
