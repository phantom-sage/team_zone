<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index()
    {
        return Client::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return string
     */
    public function create()
    {
        return 'create';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreClientRequest $request
     * @return string
     */
    public function store(StoreClientRequest $request)
    {
        $data = $request->safe(['username', 'email']);
        $client = new Client();
        $client['username'] = $data['username'];
        $client['email'] = $data['email'];
        $client->save();
        return 'store';
    }

    /**
     * Display the specified resource.
     *
     * @param Client $client
     * @return Client
     */
    public function show(Client $client)
    {
        return $client;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Client $client
     * @return Client
     */
    public function edit(Client $client)
    {
        return $client;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateClientRequest $request
     * @param Client $client
     * @return string
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        return 'update';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Client $client
     * @return void
     */
    public function destroy(Client $client)
    {
        $client->delete();
    }
}
