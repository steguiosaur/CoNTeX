<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blocks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('file_id')->constrained('files')->cascadeOnDelete();
            $table->string('type'); // e.g. paragraph, h1, img, ol, ul
            $table->string('rank'); // using fractional indexing
            $table->jsonb('content');
            $table->timestamps();

            $table->index(['file_id', 'rank']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blocks');
    }
};
