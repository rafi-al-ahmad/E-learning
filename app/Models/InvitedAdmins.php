<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class InvitedAdmins extends Model
{
    //
    protected $fillable = [
         'email','token','isValid','invitedBy'
    ];

}
