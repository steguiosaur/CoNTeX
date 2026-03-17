<?php

namespace App\Http\Controllers;

use App\Http\Resources\V1\VaultResource;
use App\Models\Vault;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VaultController extends Controller
{
    /**
     * GET /vaults
     * Get owned and collaborated vaults
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $myVaults = Vault::where('owner_id', $user->id)
            ->orderBy('updated_at', 'desc')
            ->get();

        $contributedVaults = Vault::select('vaults.*', 'role_assignments.role as pivot_role')
            ->join('role_assignments', 'vaults.id', '=', 'role_assignments.vault_id')
            ->where('role_assignments.user_id', $user->id)
            ->where('vaults.owner_id', '!=', $user->id)
            ->with('owner')
            ->distinct()
            ->orderBy('vaults.updated_at', 'desc')
            ->get();

        return Inertia::render('VaultsPage', [
            'myVaults' => VaultResource::collection($myVaults)->resolve(),
            'contributedVaults' => VaultResource::collection($contributedVaults)->resolve(),
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
     * POST /vaults
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            //'is_private' => 'boolean',
        ]);

        $request->user()->vaults()->create($validated);

        return back()->with('success', 'Vault created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Vault $vault)
    {
        if ($request->user()->cannot('view', $vault)) {
            abort(403);
        }

        return Inertia::render('EditorPage',[
            'vault' => new VaultResource($vault)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vault $vault)
    {
        //
    }

    /**
     * PATCH /vaults/{vault}
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vault $vault)
    {
        if ($request->user()->cannot('update', $vault)) abort(403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $vault->update($validated);

        return back()->with('success', 'Vault updated successfully.');
    }

    /**
     * DELETE /vaults/{vault}
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Vault $vault)
    {
        if ($request->user()->cannot('delete', $vault)) abort(403);
        $vault->delete();
        return back();
    }
}
