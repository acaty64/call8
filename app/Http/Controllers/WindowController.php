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
        return view('app.window.index');
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
