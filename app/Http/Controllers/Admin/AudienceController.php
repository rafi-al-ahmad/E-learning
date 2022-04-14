<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AudienceDataTable;
use App\Events\CreateModelEvent;
use App\Events\DeleteModelEvent;
use App\Events\UpdateModelEvent;
use App\Http\Controllers\Controller;
use App\Models\Audience;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class AudienceController extends Controller
{


    public function index(AudienceDataTable $audience)
    {
        $this->authorize('viewAny', Audience::class);

        return $audience->render('admin.audiences.audience-index');
    }

    public function createGet()
    {
        $this->authorize('create', Audience::class);

        return view('admin.audiences.audience-add');
    }

    public function create(Request $request)
    {
        $this->authorize('create', Audience::class);


        $data = $request->all();
        $extend_validate = [];
        // $data['rules'][] = 'timezone';
        if (isset($data['rules'])) {
            if (in_array('geo', $data['rules'])) {
                $extend_validate['geo-country'] = ['required'];
                $extend_validate['geo-state'] = ['required'];
            }
            if (in_array('timezone', $data['rules'])) {
                $extend_validate['timezone-country'] = ['required'];
                $extend_validate['timezone-state'] = ['required'];
            }
        }

        (Validator::make($data, array_merge([
            'name' => ['required'],
            'description' => ['required'],
        ], $extend_validate), [], []))->validate();


        $dataToCreate = [];

        $dataToCreate['name'] = $data['name'];
        $dataToCreate['description'] = $data['description'];

        if (isset($data['rules'])) {
            if (in_array('geo', $data['rules'])) {
                $dataToCreate['rules']['geo'] = [
                    'geo-country'  => $data['geo-country'],
                    'geo-state' => $data['geo-state']
                ];
            }
            if (in_array('timezone', $data['rules'])) {
                $dataToCreate['rules']['timezone'] = [
                    'timezone-country'  => $data['timezone-country'],
                    'timezone-state' => $data['timezone-state']
                ];
            }
        }

        $res = Audience::create($dataToCreate);

        event(new CreateModelEvent(Auth::guard()->user(), $res, $request));

        return back()->with('success', trans('app.audience.new-audience-added-successfuly'));
    }






    public function updateGet($id)
    {
        $this->authorize('update', Audience::class);
        $this->authorize('view', Audience::class);

        $audience = Audience::find($id);

        if ($audience) {
            return view('admin.audiences.audience-edit', ['audience' => $audience]);
        } else {
            return back()->withErrors(trans('app.audience.audience-not-found'));
        }
    }


    public function update(Request $request)
    {
        $this->authorize('update', Audience::class);

        $data = $request->all();
        $extend_validate = [];

        if (isset($data['rules'])) {
            if (in_array('geo', $data['rules'])) {
                $extend_validate['geo-country'] = ['required'];
                $extend_validate['geo-state'] = ['required'];
            }
            if (in_array('timezone', $data['rules'])) {
                $extend_validate['timezone-country'] = ['required'];
                $extend_validate['timezone-state'] = ['required'];
            }
        }

        (Validator::make($data, array_merge([
            'name' => ['required'],
            'description' => ['required'],
            'id' => ['required'],
        ], $extend_validate), [], []))->validate();

        $audience = Audience::find($request->id);

        if ($audience) {

            $dataToUpdate = [];

            $dataToUpdate['name'] = $data['name'];
            $dataToUpdate['description'] = $data['description'];

            if (isset($data['rules'])) {
                if (in_array('geo', $data['rules'])) {
                    $dataToUpdate['rules']['geo'] = [
                        'geo-country'  => $data['geo-country'],
                        'geo-state' => $data['geo-state']
                    ];
                }
                if (in_array('timezone', $data['rules'])) {
                    $dataToUpdate['rules']['timezone'] = [
                        'timezone-country'  => $data['timezone-country'],
                        'timezone-state' => $data['timezone-state']
                    ];
                }
            }


            $audience->update($dataToUpdate);

            event(new UpdateModelEvent(Auth::guard()->user(), $audience, $request));

            return back()->with('success', trans('app.audience.audience-updated-successfuly'));
        } else {
            return back()->withErrors(trans('app.audience.audience-not-found'));
        }
    }


    public function delete(Request $request)
    {
        $this->authorize('delete', Audience::class);

        if($audience = Audience::find($request->id)){
            $event = new DeleteModelEvent(Auth::guard()->user(),$audience,$request);
            $audience->delete();
            event($event);
            return back()->with('success', trans('app.audience.audience-deleted-successfuly'));
        }
        return back()->withErrors(trans('app.audience.audience-delete-falild'));
    }


    public function details($id)
    {
        $this->authorize('view', Audience::class);

        $audience = Audience::find($id);

        if ($audience) {
            // dd($audience);
            return view('admin.audiences.audience-details', ['audience' => $audience]);
        } else {
            return back()->withErrors(trans('app.audience.audience-not-found'));
        }
    }
}
