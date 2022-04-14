<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Foundation\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Jenssegers\MongoDB\Collection;
use Illuminate\Notifications\Notifiable;
use DB;
use Illuminate\Support\Facades\Cache;
use MongoDB\BSON\ObjectID;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that have all user permission
     *
     * @var array
     */
    protected $permissions = [];



    public function hasPermission($permission)
    {

        Cache::remember('user-permissions-' . $this->_id, \Carbon\Carbon::now()->addSeconds(5), function () {
            return $this->getPermissions();
        });
        return in_array($permission, Cache::get('user-permissions-' . $this->_id));

    }

    public function getRoleName()
    {
        $role = DB::collection('users')->raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$match' => [
                        '_id' => new ObjectId($this->_id)
                    ]
                ],
                [
                    '$lookup' => [
                        'from' => 'roles',
                        'localField' => 'role.id',
                        'foreignField' => '_id',
                        'as' => 'role_name'
                    ]
                ],
                [
                    '$project' => [
                        'role_name' => '$role_name.name',
                        '_id' => 0.0
                    ]
                ]
            ]);
        });

        $role->setTypeMap(['root' => 'array', 'document' => 'array', 'array' => 'array']);
        $role_name = $role->toArray();

        if (!empty($role_name)) {
            return $role_name[0]['role_name'][0];
        }
        return;
    }


    public function getUserRole()
    {
        return (Role::find($this->role['id']));
    }

    public function getPermissions()
    {
        $user_role = $this->getUserRole();
        if ($user_role) {
            return $user_role->getRolePermissionsAsCodesArray();
        }

        return $user_role ? $user_role : [];
    }

    public function getFullName()
    {
        return $this->getAttribute('personal-details.first-name') . ' ' . $this->getAttribute('personal-details.last-name');
    }

    public function isClosedAccount()
    {
        if ($this->getAttribute('settings.status') == "activated") {
            return false;
        }
        return true;
    }
}
