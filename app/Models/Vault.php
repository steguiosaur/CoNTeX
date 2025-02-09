<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vault extends Model
{
    use HasFactory;

    protected $primaryKey = 'vault_id';
    public $incrementing = true;
    protected $fillable = [
        'user_id',
        'vault_name',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
