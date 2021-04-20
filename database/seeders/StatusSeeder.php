<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create(['id'=>1, 'status'=>'Cerrado']);
        Status::create(['id'=>2, 'status'=>'Libre']);
        Status::create(['id'=>3, 'status'=>'Llamando']);
        Status::create(['id'=>4, 'status'=>'Atendiendo']);
        Status::create(['id'=>5, 'status'=>'En Pausa']);
    }
}
