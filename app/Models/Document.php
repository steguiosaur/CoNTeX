<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $primaryKey = 'document_id';
    public $incrementing = true;
    protected $fillable = [
        'vault_id',
        'document_name',
        'content',
    ];

    public function vault()
    {
        return $this->belongsTo(Vault::class);
    }
}
