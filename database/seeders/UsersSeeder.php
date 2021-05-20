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
	        'email' => 'master@ucss.edu.pe',
	        'email_verified_at' => now(),
            'password' => bcrypt('secret'),
	        // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
	        'remember_token' => Str::random(10),
    	]);

        User::factory(6)->create();

        $user = User::find(2);
        $user->email = 'host2@ucss.edu.pe';
        $user->save();

        $user = User::find(3);
        $user->email = 'host3@ucss.edu.pe';
        $user->save();

        $user = User::find(4);
        $user->email = 'client1@ucss.edu.pe';
        $user->save();

        $user = User::find(5);
        $user->email = 'client2@ucss.pe';
        $user->save();

        $user = User::find(6);
        $user->email = 'client3@ucss.pe';
        $user->save();

        $user = User::find(7);
        $user->email = 'client4@ucss.pe';
        $user->save();



        // factory(User::class, 5)->create();
    }
}
