<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Vault;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Vault $vault)
    {
        return Inertia::render('Documents/Create', [ // Assuming you have a Create.vue in Documents directory
            'vault' => $vault,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Vault $vault) // Receive Vault and Request
    {
        $validatedData = $request->validate([
            'document_name' => 'required|string|max:255',
            // You might not want to require content on creation, so can remove validation for 'content'
            // 'content' => 'nullable|string',
        ]);

        $vault->documents()->create([ // Use the relationship to create document associated with the vault
            'document_name' => $validatedData['document_name'],
            // 'content' => $validatedData['content'] ?? '', // If you had content validation
            'content' => '', // Initialize with empty content for new documents
        ]);

        // Redirect back to the editor or vault page, or wherever appropriate
        return redirect()->route('editor', ['vault' => $vault]); // Example: Redirect to editor, adjust route as needed
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vault $vault, Document $document) // Receive Vault and Document
    {
        // Load the document and pass it to the EditorPage.vue component
        return Inertia::render('EditorPage', [ // Assuming your editor component is EditorPage.vue
            'vault' => $vault,
            'document' => $document,
            'documentContent' => $document->content, // Pass document content
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vault $vault, Document $document) // Receive Vault, Document, and Request
    {
        $validatedData = $request->validate([
            'document_name' => 'required|string|max:255',
            'content' => 'nullable|string', // Content is nullable as it might be saved incrementally
        ]);

        $document->update([
            'document_name' => $validatedData['document_name'],
            'content' => $validatedData['content'] ?? $document->content, // Update content if provided, otherwise keep existing
        ]);

        // You might want to redirect back to the editor or document view
        return redirect()->back()->with('success', 'Document updated successfully.'); // Example: Redirect back with success message
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vault $vault, Document $document) // Receive Vault and Document
    {
        $document->delete();

        // Redirect back to the vault's document list or wherever appropriate
        return redirect()->route('vaults.show', $vault)->with('success', 'Document deleted successfully.'); // Example: Redirect to vault show page
    }
}
