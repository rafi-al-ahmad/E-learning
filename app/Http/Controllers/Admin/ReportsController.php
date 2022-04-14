<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AudienceDataTable;
use App\DataTables\ReportsDataTable;
use App\Events\CreateModelEvent;
use App\Events\DeleteModelEvent;
use App\Events\UpdateModelEvent;
use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class ReportsController extends Controller
{


    public function index(ReportsDataTable $reports)
    {
        // $this->authorize('viewAny', Audience::class);

        return $reports->render('admin.reports.reports-index');
    }


    public function delete(Request $request)
    {
        // $this->authorize('delete', Audience::class);

        if($reports = Report::find($request->id)){
            $event = new DeleteModelEvent(Auth::guard()->user(),$reports,$request);
            $reports->delete();
            event($event);
            return back()->with('success', trans('app.reports.report-deleted-successfuly'));
        }
        return back()->withErrors(trans('app.reports.report-delete-falild'));
    }


    public function details($id)
    {
        // $this->authorize('view', Audience::class);

        $report = Report::find($id);

        if ($report) {
            // dd($report);
            return view('admin.reports.report-details', ['report' => $report]);
        } else {
            return back()->withErrors(trans('app.report.report-not-found'));
        }
    }
}
