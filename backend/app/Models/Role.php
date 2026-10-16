<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * Get all permissions assigned to this role.
     *
     * Placeholder for a future permission system; returns an empty
     * collection so the role create/edit views render without error.
     */
    public function getAllPermissions(): Collection
    {
        return collect();
    }
}
