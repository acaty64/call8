<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	User::create(
        [
        	'name' => 'Master',
            'given_name' => 'master',
            'code' => '12345678901',
	        'email' => 'aarashiro@ucss.edu.pe',
	        'email_verified_at' => now(),
            'password' => bcrypt('secret'),
	        'remember_token' => Str::random(10),
    	]);

        if(env('APP_DEBUG'))
        {
            User::factory(3)->create();

            $user = User::find(2);
            $user->email = 'host2@ucss.edu.pe';
            $user->save();

            $user = User::find(3);
            $user->email = 'host3@ucss.edu.pe';
            $user->save();

            $users = User::factory(50)->create();

            foreach ($users as $item) {
                $user = User::find($item->id);
                $user->email = 'client' . $item->id . '@ucss.pe';
                $user->save();
            }

        }
    }
}
