<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\str;
use Illuminate\Support\Facades\Storage;
use App\DataTables\UsersDataTable;
use App\Events\ActivateAccount;
use App\Events\CloseAccount;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Intervention\Image\Facades\Image;


class UsersManagerController extends Controller
{
    // public function showAdmins()
    // {
    //     return view('admin.admins.accountsManagement');
    // }



    public function getUsers(UsersDataTable $user)
    {
        $this->authorize('viewAny', User::class);
        return ($user->render('admin.users.users-index'));
    }


    public function accountDetails($id)
    {
        $this->authorize('view', User::class);
        $user = User::find($id);

        // dd($user->getAttribute('personal-details')['social']['facebook']);

        if ($user) {
            return view('admin.users.user-details', ['user' => $user]);
        } else {
            return redirect(route('admin.Users'))->withErrors(trans('app.users.not-found'));
        }
    }

    public function editAcountGET($id)
    {
        $this->authorize('view', User::class);

        $user = User::find($id);
        // dd($user->getRoleName());
        if ($user) {
            return view('admin.users.user-edit', ['user' => $user]);
        } else {
            return redirect(route('admin.Users'))->withErrors(trans('app.users.not-found'));
        }
    }
    public function editAcountPOST(Request $request)
    {

        $data = ($request->all());
        Validator::make($data, [
            'first-name' => ['required'],
            'last-name' => ['required'],
            'email' => ['required'],
            'role' => ['required'],
            'country' => ['required'],
            'state' => ['required'],
            'city' => ['required'],
            'street-one' => ['required'],
        ], [], [
            // 'roles' => trans('admin.youMustChoiseOneRuleAtless'),
        ])->validate();
        $user = User::find($request->id);

        $this->authorize('update', $user);

        if ($user) {
            $user->setAttribute('personal-details.first-name', $data['first-name']);
            $user->setAttribute('personal-details.last-name', $data['last-name']);
            $user->setAttribute('personal-details.headline', $data['headline']);
            $user->setAttribute('personal-details.biography', $data['biography']);
            $user->setAttribute('personal-details.phone', $data['phone']);

            $user->setAttribute('personal-details.address.country', $data['country']);
            $user->setAttribute('personal-details.address.state', $data['state']);
            $user->setAttribute('personal-details.address.city', $data['city']);
            $user->setAttribute('personal-details.address.zip', $data['zip']);
            $user->setAttribute('personal-details.address.street-two', $data['street-two']);
            $user->setAttribute('personal-details.address.street-two', $data['street-two']);

            $user->setAttribute('email', $data['email']);
            $user->setAttribute('role.role_name', $data['role']);

            $user->save();

            return back()->with('success', trans('app.users.account-updated-successfully'));
        }
        return back()->withErrors(trans('app.users.not-found'));
    }

    public function UpdateAcountPassword(Request $request)
    {
        $this->authorize('update', User::class);

        $data = ($request->all());
        Validator::make($data, [
            'id' => ['required'],
            'password' => ['required', 'confirmed'],
        ], [], [])->validate();

        $user = User::find($request->id);

        $this->authorize('update', $user);

        if ($user) {
            $user->setAttribute('password', Hash::make($data['password']));
            $user->save();

            return back()->with('success', trans('app.users.account-updated-successfully'));
        }
        return back()->withErrors('app.users.not-found');
    }


    public function updateAvatar(Request $request)
    {

        $data = ($request->all());

        Validator::make($data, [
            'avatar' => ['required'],
            'id' => ['required'],
        ], [], [])->validate();

        $user = User::find($request->id);

        // authorize this action on submited user id
        $this->authorize('update', $user);

        $img = $data['avatar'];
        // get the base-64 string from data
        $img = str_replace('data:image/png;base64,', '', $img);
        // decode base64 string
        $image = base64_decode($img);
        // create file name and determ extension
        $safeName = Str::random(40) . '.png';
        // determ directory path
        $directory = 'avatars/';
        // determ file path
        $path = $directory . $safeName;

        $image1 = Image::make($img);
        $image1->resize(200, 200, function ($constraint) {
            $constraint->aspectRatio();
        });
        $ecoded_image = $image1->encode()->__toString();

        // save the file to disk
        Storage::disk('public')->put($path, $ecoded_image);
        // dd(true);

        // determ file path
        $storagePath = $path;

        if ($user) {
            $user->setAttribute('avatar', $storagePath);
            $user->save();
            return back()->with('success', trans('app.users.account-updated-successfully'));
        }
        return back()->withErrors('app.users.not-found');
    }


    public function closeAccount(Request $request)
    {
        $data = ($request->all());
        Validator::make($data, [
            'id' => ['required'],
        ], [], [])->validate();

        $user = User::find($request->id);

        $this->authorize('update', $user);

        if ($user) {
            $user->setAttribute('settings.status', 'closed');
            $user->save();

            event(new CloseAccount($user));

            return back()->with('success', trans('app.users.account-updated-successfully'));
        }
        return back()->withErrors('app.users.not-found');
    }

    public function activateAccount(Request $request)
    {
        $data = ($request->all());
        Validator::make($data, [
            'id' => ['required'],
        ], [], [])->validate();

        $user = User::find($request->id);

        $this->authorize('update', $user);


        if ($user) {
            $user->setAttribute('settings.status', 'activated');
            $user->save();

            event(new ActivateAccount($user));

            return back()->with('success', trans('app.users.account-updated-successfully'));
        }
        return back()->withErrors('app.users.not-found');
    }

    public function ShowClosedAccountView(Request $request)
    {
        if (Auth::guard('admin')->user()->status == 'closed') {
            return view('admin.auth.closedAccount');
        }
        return redirect(route('admin.home'));
    }




}


