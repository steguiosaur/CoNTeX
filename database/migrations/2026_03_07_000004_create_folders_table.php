<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS ltree;');

        Schema::create('folders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('vault_id')->constrained('vaults')->cascadeOnDelete();
            $table->uuid('parent_id')->nullable();
            $table->string('name');
            $table->timestamps();

        });
        Schema::table('folders', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('folders')->cascadeOnDelete();
        });

        DB::statement('ALTER TABLE folders ADD COLUMN path ltree;');
        DB::statement('CREATE INDEX folders_path_gist_idx ON folders USING GIST (path);');
    }

    public function down(): void
    {
        Schema::dropIfExists('folders');
        DB::statement('DROP EXTENSION IF EXISTS ltree;');
    }
};
