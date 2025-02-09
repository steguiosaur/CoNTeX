<?php

namespace App\Http\Controllers;

use App\Models\Vault;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VaultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vaults = Vault::where('user_id', auth()->id())->get();
        return Inertia::render('VaultsPage', [
            'myVaults' => $vaults,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'vault_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Vault::create([
            'user_id' => auth()->id(),
            'vault_name' => $request->vault_name,
            'description' => $request->description,
        ]);

        return redirect()->route('vaults.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vault $vault)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vault $vault)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vault $vault)
    {
        $request->validate([
            'vault_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $vault->update([
            'vault_name' => $request->vault_name,
            'description' => $request->description,
        ]);

        return redirect()->route('vaults.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vault $vault)
    {
        $vault->delete();
        return redirect()->route('vaults.index');
    }
}
