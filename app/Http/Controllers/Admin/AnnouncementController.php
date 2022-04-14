<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AnnouncementsDataTable;
use App\Events\CreateModelEvent;
use App\Events\DeleteModelEvent;
use App\Events\UpdateModelEvent;
use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Audience;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;
use MongoDB\BSON\UTCDateTime ;
class AnnouncementController extends Controller
{
    //
    public function announcements(AnnouncementsDataTable $announcements)
    {
        $this->authorize('viewAny', Announcement::class);

        return $announcements->render('admin.announcement.announcement-index');

    }

    public function newAnnouncement()
    {
        $this->authorize('create', Announcement::class);

        $audience = Audience::all();
        return view('admin.announcement.announcement-add', [ 'audience' => $audience]);
    }

    public function create(Request $request)
    {
        $this->authorize('create', Announcement::class);

        $data = $request->all();
        unset($data['_token']);
        unset($data['files']);

        (Validator::make($data, [
            'announcement' => ['required'],
            'announcementDatetimeRange' => ['required'],
            'announcementStartDate' => ['required'],
            'announcementEndDate' => ['required'],
            'audience' => ['required'],
            'description' => ['required'],
            'timer-font-color' => ['required'],
            'timer-background-color' => ['required'],
        ], [], []))->validate();


        $data['announcementStartDate'] = new UTCDateTime($data['announcementStartDate']);
        $data['announcementEndDate'] = new UTCDateTime($data['announcementEndDate']);

        $res = Announcement::create($data);
        event(new CreateModelEvent(Auth::guard()->user(),$res,$request));

        Cache::forget('announcements');

        return back()->with('success', trans('app.announcement.new-announcement-added-successfuly'));
    }

    public function edit($id)
    {
        $this->authorize('update', Announcement::class);
        $this->authorize('view', Announcement::class);

        $announcement = Announcement::find($id);
        $audience = Audience::all();

        return view('admin.announcement.announcement-edit', [ 'announcement' => $announcement, 'audience' => $audience]);
    }

    public function editPost(Request $request)
    {
        $this->authorize('update', Announcement::class);

        $data = $request->all();
        unset($data['_token']);
        unset($data['files']);

        (Validator::make($data, [
            'id' => ['required'],
            'announcement' => ['required'],
            'announcementDatetimeRange' => ['required'],
            'announcementStartDate' => ['required'],
            'announcementEndDate' => ['required'],
            'audience' => ['required'],
            'description' => ['required'],
            'timer-font-color' => ['required'],
            'timer-background-color' => ['required'],
        ], [], []))->validate();
        $announcement = Announcement::find($request->id);


        $announcement->update($data);

        event(new UpdateModelEvent(Auth::guard()->user(),$announcement,$request));

        Cache::forget('announcements');

        return back()->with('success', trans('app.announcement.announcement-updated-successfuly'));
    }


    public function delete(Request $request)
    {
        $this->authorize('delete', Announcement::class);

        if($announcement = Announcement::find($request->id)){
            $event = new DeleteModelEvent(Auth::guard()->user(),$announcement,$request);
            $announcement->delete();

            event($event);

            Cache::forget('announcements');

            return back()->with('success', trans('app.announcement.announcement-deleted-successfuly'));
        }
        return back()->withErrors(trans('app.announcement.announcement-delete-falild'));
    }

    public function details($id)
    {
        $this->authorize('view', Announcement::class);

        $announcement = Announcement::find($id);
        $audience = Audience::all();

        return view('admin.announcement.announcement-details', [ 'announcement' => $announcement, 'audience' => $audience]);
    }

}
