<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vault extends Model
{
    use HasUuids;

    protected $fillable = [
        'owner_id',
        'name',
        'description',
        'is_private',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }

    public function folders(): HasMany
    {
        return $this->hasMany(Folder::class);
    }
}
