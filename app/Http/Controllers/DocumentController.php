<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{

    public function index()
    {
        $data = Document::paginate(5);
        return view('app.document.index')
            ->with('index', $data);
    }

    public function create()
    {
        return view('app.document.create');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'file' => 'required',
            'order' => 'required',
        ]);

        $file_saved = $request->file->store('public/docs', 'local');

        $active_check = ($request->active == "on") ? true : false;

        $document = Document::create(
            [
                'order' => $request->order,
                'name' => $request->name,
                'filename' => $request->file->getClientOriginalName(),
                'link' => $file_saved,
                'active' => $active_check
            ]
        );

        return redirect(route('documents.index'));

    }

    public function show($id)
    {
        $item = Document::findOrFail($id);
        $link = '/storage/docs/' . basename($item->link); 
        return view('app.document.show', [
            'item' => [
                'src' => $link,
                'filename' => $item->filename,
            ]
        ]);
    }

    public function edit($id)
    {
        $item = Document::findOrFail($id);
        return view('app.document.edit')->with('item', $item);
    }

    public function update(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'file' => 'required',
            'order' => 'required',
        ]);

        $active_check = ($request->active == "on") ? true : false;
        $document = Document::findOrFail($request->id);

        $document->order = $request->order;
        $document->name = $request->name;
        $document->active = $active_check;
        if(!is_null($request->file)){
            $file_saved = $request->file->store('public/docs', 'local');
            $document->link = $file_saved;
            $document->filename = $request->file->getClientOriginalName();
        }
        $document->save();

        return redirect(route('documents.index'));

    }

    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        $document->delete();
        return redirect(route('documents.index'));

    }
}
