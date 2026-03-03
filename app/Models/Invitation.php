<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invitation extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_name',
        'email',
        'company_id',
        'inviter_id',
    ];
     public function inviter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inviter_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
