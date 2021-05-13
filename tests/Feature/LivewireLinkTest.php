<?php

namespace Tests\Feature;

use App\Http\Livewire\LinkIndex;
use App\Models\Link;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireLinkTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function link_index_page_contains_livewire_component()
    {
        $admin = User::find(1);
        Livewire::actingAs($admin)
            ->test(LinkIndex::class)
            ->assertSeeHtml('Indice de Enlaces');

    }

    /** @test */
    public function admin_can_add_link_registry()
    {
        $admin = User::find(1);
        $this->actingAs($admin);

        Livewire::actingAs($admin)
            ->test(LinkIndex::class)
            ->set('status', 'create')
            ->assertSeeHtml('Nuevo Enlace');

        $data = [
            'order' => 10,
            'name' => 'Link test',
            'link' => '12345678901',
            'description' => "The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from 'de Finibus Bonorum et Malorum' by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.",
            'active' => 1,
        ];

        Livewire::actingAs($admin)
            ->test(LinkIndex::class)
            ->call('setStatus', 'create')
            ->set('order', $data['order'])
            ->set('name', $data['name'])
            ->set('link', $data['link'])
            ->set('description', $data['description'])
            ->set('active', $data['active'])
            ->call('save');
            // ->assertSeeHtml('Registro grabado.');

        $this->assertDatabaseHas('links', $data);

    }

    /** @test */
    public function admin_can_update_link_registry()
    {
        $admin = User::find(1);
        $this->actingAs($admin);

        $data = [
            'order' => 3,
            'name' => 'Link test',
            'link' => '12345678901',
            'description' => "The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from 'de Finibus Bonorum et Malorum' by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.",
            'active' => 1,
        ];

        $link = Link::create($data);
        $this->assertDatabaseHas('links', $data);

        $newData = [
            'order' => 3,
            'name' => 'New Link test',
            'link' => '99999999999',
            'description' => "Lorem ipsum dolor sit amet consectetur adipiscing elit etiam, quis magna volutpat nam suscipit dis at, tristique penatibus leo libero pellentesque justo vehicula. Rhoncus risus aenean odio imperdiet suscipit sed penatibus aptent, mauris nibh nisl montes enim tempor turpis, dui cras quis hendrerit senectus nascetur felis. Ligula ornare cum imperdiet congue orci primis blandit natoque etiam vehicula pharetra quam consequat, lacinia est praesent nulla donec vestibulum maecenas luctus augue mauris fermentum.",
            'active' => 1,
        ];

        Livewire::actingAs($admin)
            ->test(LinkIndex::class)
            ->set('status', 'edit')
            ->assertSeeHtml('Edición de Enlace');

        Livewire::actingAs($admin)
            ->test(LinkIndex::class)
            ->call('setStatus', 'edit', $link->id)
            ->assertSet('link', $data['link'])
            ->set('name', $newData['name'])
            ->set('link', $newData['link'])
            ->set('description', $newData['description'])
            ->set('active', $newData['active'])
            ->call('save');

        $this->assertDatabaseHas('links', $newData);
        $this->assertDatabaseMissing('links', $data);

    }

    /** @test */
    public function admin_can_destroy_a_link_registry()
    {
        $admin = User::find(1);
        $this->actingAs($admin);
        $link = Link::find(1);

        Livewire::actingAs($admin)
            ->test(LinkIndex::class)
            ->call('setStatus', 'destroy', $link->id)
            ->assertSet('link_id', $link->id)
            ->assertSeeHtml('Enlace a Eliminar')
            ->call('save', 'destroy');
            // ->assertSeeHtml('Registro grabado.');

        $this->assertDatabaseMissing('links', $link->toArray());

    }


}
