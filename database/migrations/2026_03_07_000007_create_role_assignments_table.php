<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('role_assignments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('account_id')->constrained('accounts')->cascadeOnDelete();
            $table->foreignUuid('vault_id')->constrained('vaults')->cascadeOnDelete();
            $table->foreignUuid('folder_id')->nullable()->constrained('folders')->cascadeOnDelete();
            $table->foreignUuid('file_id')->nullable()->constrained('files')->cascadeOnDelete();
            $table->enum('role', ['viewer', 'editor', 'admin']);
            $table->timestamps();

            $table->index(['account_id', 'vault_id']);
        });

        // role should not be assigned to both folder and file at the same time
        // num_nonnulls() checks how many of the arguments are not null
        // 0 (Vault level) or 1 (Folder or File level)
        DB::statement('
            ALTER TABLE role_assignments
            ADD CONSTRAINT chk_exclusive_arc
            CHECK (num_nonnulls(folder_id, file_id) <= 1);
        ');
    }
    public function down(): void
    {
        Schema::dropIfExists('role_assignments');
    }
};
