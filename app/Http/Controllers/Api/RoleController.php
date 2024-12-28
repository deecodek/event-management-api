<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $roles = QueryBuilder::for(Role::class)
            ->allowedFilters([
                'name',
                AllowedFilter::exact('id'),
            ])
            ->allowedIncludes(['permissions', 'users'])
            ->allowedSorts('name', 'created_at')
            ->paginate();

        return RoleResource::collection($roles);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);

        $role = Role::create(['name' => $request->name]);
        return new RoleResource($role);
    }

    public function show(Role $role)
    {
        $role->load(['permissions', 'users']);
        return new RoleResource($role);
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
        ]);

        $role->update(['name' => $request->name]);
        return new RoleResource($role);
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json(['message' => 'Role deleted successfully']);
    }
}
