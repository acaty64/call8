<?php

namespace Tests\Feature;

use App\Http\Livewire\UserCrud;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireUserTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function user_index_page_contains_livewire_component()
    {
        $admin = User::find(1);
        Livewire::actingAs($admin)
            ->test(UserCrud::class)
            ->assertSeeHtml('Nombre')
            ->assertSeeHtml('E-mail')
            ->assertSeeHtml('Codigo')
            ;

    }

    /** @test */
    public function admin_can_add_user_registry()
    {
        $admin = User::find(1);
        $this->actingAs($admin);

        Livewire::actingAs($admin)
            ->test(UserCrud::class)
            ->set('status', 'create')
            ->assertSeeHtml('Nuevo Usuario');

        $data = [
            'email' => 'aaaa@example.com',
            'name' => 'Aaaa Bbbb Cccc',
            'given_name' => 'Aaaa',
            'code' => '12345678901',
        ];

        Livewire::actingAs($admin)
            ->test(UserCrud::class)
            ->call('setStatus', 'create')
            ->set('email', $data['email'])
            ->set('name', $data['name'])
            ->set('given_name', $data['given_name'])
            ->set('code', $data['code'])
            ->call('save');
            // ->assertSeeHtml('Registro grabado.');

        $this->assertDatabaseHas('users', $data);

    }

    /** @test */
    public function admin_can_update_user_registry()
    {
        $admin = User::find(1);
        $this->actingAs($admin);

        $data = [
            'email' => 'aaaa@example.com',
            'name' => 'Aaaa Bbbb Cccc',
            'given_name' => 'Aaaa',
            'code' => '12345678901',
        ];

        $user = User::create($data);
        $this->assertDatabaseHas('users', $data);

        $newData = [
            'email' => 'xxxx@example.com',
            'name' => 'Xxxx Bbbb Cccc',
            'given_name' => 'Xxxx',
            'code' => '9999999999',
        ];

        Livewire::actingAs($admin)
            ->test(UserCrud::class)
            ->set('status', 'edit')
            ->assertSeeHtml('Edición de Usuario');

        Livewire::actingAs($admin)
            ->test(UserCrud::class)
            ->call('setStatus', 'edit', $user->id)
            ->assertSet('name', $data['name'])
            ->set('name', $newData['name'])
            ->set('given_name', $newData['given_name'])
            ->set('email', $newData['email'])
            ->set('code', $newData['code'])
            ->call('save');

        $this->assertDatabaseHas('users', $newData);
        $this->assertDatabaseMissing('users', $data);

    }

    /** @test */
    // public function admin_can_destroy_a_user_registry()
    // {
    //     $admin = User::find(1);
    //     $this->actingAs($admin);
    //     $user = User::find(5);

    //     Livewire::actingAs($admin)
    //         ->test(UserCrud::class)
    //         ->call('setStatus', 'destroy', $user->id)
    //         ->assertSet('user_id', $user->id)
    //         ->assertSeeHtml('Usuario a Eliminar')
    //         ->call('save', 'destroy');
    //         // ->assertSeeHtml('Registro grabado.');

    //     $this->assertDatabaseMissing('users', $user->toArray());

    // }


}
