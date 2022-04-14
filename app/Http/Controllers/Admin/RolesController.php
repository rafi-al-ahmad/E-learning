<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\RolesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use MongoDB\BSON\ObjectID;
use DB;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
{
    //
    protected $id;
    public function roles(RolesDataTable $roles)
    {
        $this->authorize('viewAny', Role::class);

        return $roles->render('admin.roles.roles-index');
    }



    public function details($id)
    {
        $this->authorize('view', Role::class);

        $role = Role::find($id);
        $permissions = Permission::all();


        $permission_groups = DB::collection('permissions')->raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$group' => [
                        '_id' => [
                            'group' => '$group'
                        ]
                    ]
                ],
                [
                    '$project' => [
                        'group' => '$_id.group',
                        '_id' => 0
                    ]
                ]
            ]);
        });

        $permission_groups->setTypeMap(['root' => 'array', 'document' => 'array', 'array' => 'array']);
        $permission_groups_array = $permission_groups->toArray();

        foreach ($permission_groups_array as $key => $group) {
            $permission_groups_array[$key] = $group['group'];
        }
        sort($permission_groups_array);

        $role_permissions_by_group = [];
        foreach ($permission_groups_array as  $group) {
            foreach ($permissions as  $permission) {
                if ($permission->group == $group) {
                    $role_permissions_by_group[$group][] = [
                        'name' => $permission->name,
                        'code' => $permission->code,
                        'status' => in_array($permission->_id, $role->permissions)
                    ];
                }
            }
        }

        return view('admin.roles.role-details', ['role' => $role, 'role_permissions_by_group' => $role_permissions_by_group]);
    }




    public function edit($id)
    {

        $this->authorize('view', Role::class);

        $role = Role::find($id);
        $permissions = Permission::all();
        $permission_groups = DB::collection('permissions')->raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$group' => [
                        '_id' => [
                            'group' => '$group'
                        ]
                    ]
                ],
                [
                    '$project' => [
                        'group' => '$_id.group',
                        '_id' => 0
                    ]
                ]
            ]);
        });

        $permission_groups->setTypeMap(['root' => 'array', 'document' => 'array', 'array' => 'array']);
        $permission_groups_array = $permission_groups->toArray();

        foreach ($permission_groups_array as $key => $group) {
            $permission_groups_array[$key] = $group['group'];
        }
        sort($permission_groups_array);

        $role_permissions_by_group = [];
        foreach ($permission_groups_array as  $group) {
            foreach ($permissions as  $permission) {
                if ($permission->group == $group) {
                    $role_permissions_by_group[$group][] = [
                        'name' => $permission->name,
                        'code' => $permission->code,
                        'status' => in_array($permission->_id,$role->permissions)
                    ];
                }
            }
        }

        return view('admin.roles.role-edit', ['role' => $role, 'role_permissions_by_group' => $role_permissions_by_group]);
    }



    public function update(Request $request)
    {
        $this->authorize('update', Role::class);


        $role = Role::find($request->role_id);
        // dd($role->permissions);
        if ($role) {
            $permissions = Permission::whereIn('code', $request->permissions)->get();

            $role_permissions = [];
            foreach ($permissions as $key => $permission) {
                array_push($role_permissions, new ObjectID($permission->_id));
            }

            $role->name = $request->name;
            $role->description = $request->description;
            $role->permissions = $role_permissions;
            $role->save();

            return back()->with('success', trans('app.role.updated-successfuly'));
        } else {
            return redirect(route('admin.showRoles'))->withErrors(trans('app.role.not-found'));
        }
    }

    public function newRole()
    {
        $this->authorize('create', Role::class);

        $permissions = Permission::all();
        $permission_groups = DB::collection('permissions')->raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$group' => [
                        '_id' => [
                            'group' => '$group'
                        ]
                    ]
                ],
                [
                    '$project' => [
                        'group' => '$_id.group',
                        '_id' => 0
                    ]
                ]
            ]);
        });

        $permission_groups->setTypeMap(['root' => 'array', 'document' => 'array', 'array' => 'array']);
        $permission_groups_array = $permission_groups->toArray();

        foreach ($permission_groups_array as $key => $group) {
            $permission_groups_array[$key] = $group['group'];
        }
        sort($permission_groups_array);

        $permissions_by_groups = [];
        foreach ($permission_groups_array as  $group) {
            foreach ($permissions as  $permission) {
                if ($permission->group == $group) {
                    $permissions_by_groups[$group][] = [
                        'name' => $permission->name,
                        'id' => $permission->_id,
                    ];
                }
            }
        }

        return view('admin.roles.role-create', ['permissions_by_groups' => $permissions_by_groups]);
    }

    public function create(Request $request)
    {
        $this->authorize('create', Role::class);

        $data = ($request->all());

        Validator::make($data,[
            'name' => ['required'],
        ], [], [])->validate();

        $role = new Role();


        // $permissions = Permission::whereIn('code', $request->permissions)->get();
        // dd($request->permissions);
        $role_permissions = [];
        if ($request->permissions) {
            foreach ($request->permissions as $permission) {
                array_push($role_permissions, new ObjectID($permission));
            }
        }

        $role->name = $request->name;
        $role->description = $request->description;
        $role->permissions = $role_permissions;
        $role->save();

        return redirect(route('admin.showRoles'))->with('success', trans('app.role.created-successfuly'));
    }

    public function delete (Request $request)
    {
        $this->authorize('delete', Role::class);

        $data = ($request->all());

        Validator::make($data,[
            'id' => ['required'],
        ], [], [])->validate();
        if(Role::find($request->id)->delete()){

            return back()->with('success', trans('app.role.deleted-successfuly'));
        }else {
            return back()->withErrors(trans('app.something-went-wrong'));
        }

    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

}
