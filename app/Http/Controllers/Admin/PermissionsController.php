<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermissionsRequest;
use App\Http\Resources\PermissionResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{

    private $routesResourceName = 'permissions';
    private $resourceTitle = 'Permission';


    public function __construct()
    {
        $this->middleware('can:view permissions list')->only('index');
        $this->middleware('can:create permission')->only(['create', 'store']);
        $this->middleware('can:edit permission')->only(['edit', 'update']);
        $this->middleware('can:delete permission')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $permissions = Permission::when($request->name, function ($query, $name) {
            return $query->where('name', 'like', "%{$name}%");
        })->paginate(10);


        return Inertia::render('Permissions/Index', [
            'items' => PermissionResource::collection($permissions),
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
            'can' => $request->user()?->can('create permission')

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Permissions/Create', [
            'title' => $this->resourceTitle,
            'routeResourceName' => $this->routesResourceName

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionsRequest $request)
    {
        Permission::create($request->validated());

        return redirect()->route('admin.' . $this->routesResourceName . '.index')->with('success',  $this->resourceTitle . 'Created Successfully');
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
    public function edit(Permission $permission)
    {

        return Inertia::render('Permissions/Create', [
            'edit' => true,
            'item' => new PermissionResource($permission),
            'title' => $this->resourceTitle,
            'routeResourceName' => $this->routesResourceName

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionsRequest $request, Permission $permission)
    {
        $permission->update($request->validated());

        return redirect()->route('admin.' . $this->routesResourceName . '.index')->with('success',  $this->resourceTitle . 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return back()->with('success',  $this->resourceTitle . 'Deleted Successfully');
    }
}
