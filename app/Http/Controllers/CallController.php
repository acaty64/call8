<?php

namespace App\Http\Controllers;

use App\Models\Call;
use App\Models\Status;
use App\Models\Trace;
use App\Models\User;
use Illuminate\Http\Request;

class CallController extends Controller
{

    public function client()
    {
        return view('app.client.screen');
    }

    public function index()
    {
        $calls = Call::all()->sortByDesc('id');
        return view('app.call.index')->with([
            'data' => $calls
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    public function store()
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Call  $call
     * @return \Illuminate\Http\Response
     */
    public function show(Call $call)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Call  $call
     * @return \Illuminate\Http\Response
     */
    public function edit(Call $call)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Call  $call
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Call $call)
    {
        // call our event here
        event(new CallEvent($request));

        return 'App/Http/Controllers/CallController/update';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Call  $call
     * @return \Illuminate\Http\Response
     */
    public function destroy(Call $call)
    {
        //
    }
}
