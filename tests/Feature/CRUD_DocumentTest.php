<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\User;
use App\StatusUser;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CRUD_DocumentTest extends TestCase
{
    use DatabaseTransactions;

    public function test_document_index_view()
    {
        $admin = User::find(2);
        $this->actingAs($admin);
        $this->assertTrue($admin->is_admin);

        $response = $this->get('/documents/index');
        $response->assertStatus(200);
        $response->assertViewIs('app.document.index');
    }

    public function test_create_a_document()
    {
        $admin = User::find(2);
        $this->actingAs($admin);
        $response = $this->get('/document/create');
        $response->AssertViewIs('app.document.create');
        $response->assertStatus(200);
    }

    public function test_store_a_new_document()
    {
        $admin = User::find(2);
        $this->actingAs($admin);

        $local_file = storage_path('app/public/docs/test/document_fake.pdf');

        $uploadedFile = new UploadedFile(
            $local_file,
            'document_fake.pdf',
            'application/pdf',
            null,
            // null,
            true
        );

        $request = [
                'order' => 1,
                'name'       => 'Documento de prueba',
                'file'     => $uploadedFile,
                'active'       => 'on',
            ];

        $response = $this->post(route('document.store') , $request);
        $data = [
                'order' => $request['order'],
                'name'       => $request['name'],
                'filename'       => 'document_fake.pdf',
                'active'       => ($request['active'] == 'on') ? 1 : 0,
        ];
        $this->assertDatabaseHas('documents', $data);

        $response->assertStatus(302);
        $response->assertRedirect(route('documents.index'));
    }

    public function test_edit_a_document()
    {
        $admin = User::find(2);
        $this->actingAs($admin);

        $document = Document::create([
            'order' => 1,
            'name' => 'Old Document',
            'filename' => 'fake.pdf',
            'link' => 'file_name_faked',
            'active' => true
        ]);

        $response = $this->get('/document/' . $document->id . '/edit');
        $response->assertStatus(200);
        $response->assertViewIs('app.document.edit');
    }

    public function test_update_a_document_with_new_file()
    {

        $admin = User::find(2);
        $this->actingAs($admin);

        $old_document = Document::create([
                    'order' => 1,
                    'name' => 'Old Document',
                    'filename' => 'old_fake.pdf',
                    'link' => 'file_name_faked',
                    'active' => true
                ]);

        $local_file = storage_path('app/public/docs/test/document_fake.pdf');

        $uploadedFile = new UploadedFile(
            $local_file,
            'document_fake.pdf',
            'application/pdf',
            null,
            // null,
            true
        );

        $request = [
            'id' => $old_document->id,
            'order' => 2,
            'name' => 'New Document',
            'file' => $uploadedFile,
            'active' => 'off'
        ];

        $response = $this->post(route('document.update'), $request);

        $data = [
            'id' => $old_document->id,
            'order' => $request['order'],
            'name' => $request['name'],
            'filename' => $uploadedFile->getClientOriginalName(),
            'active' => ($request['active'] == 'on') ? 1 : 0,
        ];

        $this->assertDatabaseHas('documents', $data);
        $response->assertStatus(302);
        $response->assertRedirect(route('documents.index'));
    }

    public function test_view_a_document()
    {
        $host = User::find(2);
        $this->actingAs($host);
        $this->assertFalse($host->is_master);
        $this->assertTrue($host->is_admin);

        $local_file = storage_path('app/public/docs/test/document_fake.pdf');

        $uploadedFile = new UploadedFile(
            $local_file,
            'document_fake.pdf',
            'application/pdf',
            null,
            // null,
            true
        );

        $old_document = [
                'order' => 1,
                'name'       => 'Documento de prueba',
                'file'     => $uploadedFile,
                'active'       => 'on',
            ];

        $response = $this->post(route('document.store') , $old_document);

        $document = Document::all()->first();
        $response = $this->get('/document/' . $document->id . '/show');
        $response->assertStatus(200);
    }

    public function test_delete_a_document()
    {

        $admin = User::find(2);
        $this->actingAs($admin);
        $this->assertTrue($admin->is_admin);

        $local_file = storage_path('app/public/docs/test/document_fake.pdf');

        $uploadedFile = new UploadedFile(
            $local_file,
            'document_fake.pdf',
            'application/pdf',
            null,
            // null,
            true
        );

        $old_document = [
                'order' => 1,
                'name'       => 'Documento de prueba',
                'file'     => $uploadedFile,
                'active'       => 'on',
            ];

        $response = $this->post(route('document.store') , $old_document);

        $document = Document::all()->first();

        $response = $this->get(route('document.destroy' , $document->id));

        $response->assertStatus(302);

        $this->assertDatabaseMissing('documents', [
                'id' => $document->id,
            ]);

    }


}

