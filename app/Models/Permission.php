<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as Model;

class Permission extends Model
{
    public function sidebars()
    {
        return $this->belongsToMany(Sidebar::class, 'sidebar_permissions');
    }
}