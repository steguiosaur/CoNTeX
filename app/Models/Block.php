<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Block extends Model
{
    use HasUuids;

    protected $fillable = ['file_id', 'type', 'rank', 'content'];

    protected function casts(): array
    {
        return [
            'content' => 'array',
        ];
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

}
