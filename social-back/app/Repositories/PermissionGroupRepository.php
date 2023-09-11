<?php
namespace App\Repositories;

use App\Models\PermissionGroup;

class PermissionGroupRepository
{
    public function listing($request)
    {
        
        return PermissionGroup::with('permissions')->select('id', 'name')->paginate( $request->perPage );

    }
}
