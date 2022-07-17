<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RolesRequest;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{

    private $routesResourceName = 'roles';
    private $resourceTitle = 'Role';

    public function __construct()
    {
        $this->middleware('can:view roles list')->only('index');
        $this->middleware('can:create role')->only(['create', 'store']);
        $this->middleware('can:edit role')->only(['edit', 'update']);
        $this->middleware('can:delete role')->only('destroy');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $roles = Role::when($request->name, function ($query, $name) {
            return $query->where('name', 'like', "%{$name}%");
        })->paginate(10);


        return Inertia::render('Roles/Index', [
            'items' => RoleResource::collection($roles),
            'headers' => [
                [
                    'label' => 'ID',
                    'name' => 'id',
                ],
                [
                    'label' => 'Name',
                    'name' => 'name',
                ],
                [
                    'label' => 'Created At',
                    'name' => 'created_at_formatted',
                ],
                [
                    'label' => 'Actions',
                    'name' => 'actions',
                ]
            ],
            'title' => $this->resourceTitle,
            'filters' => (object) $request->all(),
            'routeResourceName' => $this->routesResourceName,
            'can' => $request->user()?->can('create role')

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Roles/Create', [
            'title' => $this->resourceTitle,
            'routeResourceName' => $this->routesResourceName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RolesRequest $request)
    {
        $role = Role::create($request->validated());

        return redirect()->route('admin.' . $this->routesResourceName . '.edit', $role)->with('success', $this->resourceTitle . 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {

        $role->load(['permissions:permissions.id,permissions.name']);


        return Inertia::render('Roles/Create', [
            'edit' => true,
            'item' => new RoleResource($role),
            'title' => $this->resourceTitle,
            'routeResourceName' => $this->routesResourceName,
            'permissions' => PermissionResource::collection(Permission::oldest('id')->get(['id', 'name'])),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RolesRequest $request, Role $role)
    {
        $role->update($request->validated());

        return redirect()->route('admin.' . $this->routesResourceName . '.index')->with('success', $this->resourceTitle . 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return back()->with('success', $this->resourceTitle . 'Deleted Successfully');
    }
}
