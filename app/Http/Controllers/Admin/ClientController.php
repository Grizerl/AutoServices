<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ClientController extends Controller
{
    public function index(): View
    {
        return view('admin.client.index', [
            'client' => Client::latest()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.client.create');
    }

    public function store(ClientRequest $request): RedirectResponse
    {
        Client::create($request->validated());

        return redirect()->route('client.index')->with('success', 'The review has been created.');
    }

    public function edit(Client $client): View
    {
        return view('admin.client.edit', ['client' => $client]);
    }

    public function update(ClientRequest $request, Client $client): RedirectResponse
    {
        $client->update($request->validated());

        return redirect()->route('client.index')->with('success', 'The review has been updated.');
    }

    public function destroy(Client $client): RedirectResponse
    {
        $client->delete();

        return redirect()->route('client.index')->with('success', 'The review has been deleted.');
    }
}
