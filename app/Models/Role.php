<?php

namespace App\Models;

use MongoDB\BSON\ObjectID;

use Jenssegers\Mongodb\Eloquent\Model;
use DB;
class Role extends Model
{
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'permissions',
    ];

    public function getRolePermissions()
    {
        return DB::collection('roles')->raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$match' => [
                        '_id' =>  $this->_id
                    ]
                ],
                [
                    '$lookup' => [
                        'from' => 'permissions',
                        'localField' => 'permissions',
                        'foreignField' => '_id',
                        'as' => 'role_permissions'
                    ]
                ],
                [
                    '$project' => [
                        'role_permissions' => '$role_permissions',
                        '_id' => 0.0
                    ]
                ]
            ]);
        });
    }

    public function getRolePermissionsAsCodesArray()
    {

        $permissions = (( DB::collection('roles')->raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$match' => [
                        '_id' => new ObjectId($this->_id)
                    ]
                ],
                [
                    '$lookup' => [
                        'from' => 'permissions',
                        'localField' => 'permissions',
                        'foreignField' => '_id',
                        'as' => 'role_permissions'
                    ]
                ],
                [
                    '$project' => [
                        'permissions_codes' => '$role_permissions.code',
                        '_id' => 0.0
                    ]
                ]
            ]);
        })));
        $permissions->setTypeMap(['root' => 'array', 'document' => 'array', 'array' => 'array']);
        $permissions_array = [];

        foreach ($permissions->toArray()[0] as  $value) {
            foreach ($value as $key => $permission) {
                $permissions_array[] = $permission;
            }
        }

        return ($permissions_array );
    }





}
