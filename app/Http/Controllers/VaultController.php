<?php

namespace App\Http\Controllers;

use App\Http\Resources\VaultResource;
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
     * GET /vaults/{vault}
     * Display Vault contents like files and folders.
     */
    public function show(Request $request, Vault $vault)
    {
        if ($request->user()->cannot('view', $vault)) {
            abort(403, 'You do not have access to this vault.');
        }

        // Auto-create file if file does not exist in Vault
        if ($vault->files()->doesntExist()) {
            $newFile = $vault->files()->create([
                'name' => 'Untitled Document',
                'folder_id' => null,
            ]);

            // Create first block for editor to edit into
            $newFile->blocks()->create([
                'type' => 'markdown',
                'rank' => 'a',
                'content' => ['text' => ''],
            ]);
        }

        // Fetch File Tree (Folders and Files)
        $folders = $vault->folders()->select('id', 'parent_id', 'name', 'path')->orderBy('path')->get();
        $files = $vault->files()->select('id', 'folder_id', 'name')->orderBy('name')->get();

        return Inertia::render('EditorPage',[
            'vault' =>[
                'id' => $vault->id,
                'name' => $vault->name,
            ],
            'folders' => $folders,
            'files' => $files,
        ]);
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
