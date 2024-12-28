<?php

namespace App\Http\Controllers\Api;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Resources\PermissionResource;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $permissions = QueryBuilder::for(Permission::class)
            ->allowedFilters([
                'name',
                AllowedFilter::exact('id'),
            ])
            ->allowedIncludes(['roles', 'users'])
            ->allowedSorts('name', 'created_at')
            ->paginate();

        return PermissionResource::collection($permissions);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name',
        ]);

        $permission = Permission::create(['name' => $request->name]);
        return new PermissionResource($permission);
    }

    public function show(Permission $permission)
    {
        $permission->load(['roles', 'users']);
        return new PermissionResource($permission);
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update(['name' => $request->name]);
        return new PermissionResource($permission);
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return response()->json(['message' => 'Permission deleted successfully']);
    }
}
