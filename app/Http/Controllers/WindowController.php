<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Trace;
use App\Models\Window;
use Illuminate\Http\Request;

class WindowController extends Controller
{
    public function index()
    {
        $data = Window::all();
        return view('app.window.index')->with('data', $data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
