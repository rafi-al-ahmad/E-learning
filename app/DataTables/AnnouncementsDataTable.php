<?php

namespace App\DataTables;

use App\Models\Announcement;
use Carbon\Carbon;
use Illuminate\Database\DBAL\TimestampType;
use Illuminate\Support\Facades\Date;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AnnouncementsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('Action', 'Admin.announcement.Action')
            ->rawColumns([
                'Action',
            ])
            ->editColumn('created_at', function ($announcement) {
                return $announcement->created_at ? with(new Carbon($announcement->created_at))->format('Y-m-d H:i') : '';
            })
            ->editColumn('description', function ($announcement) {
                return $announcement->description && strlen($announcement->description) > 40 ? substr($announcement->description, 0, 30) . '. . .' : $announcement->description;
            })
            ->editColumn('announcementStartDate', function ($announcement) {
                return $announcement->announcementStartDate ? with( Carbon::createFromTimestampMs($announcement->announcementStartDate))->format('jS \o\f F, Y H:i') : '';
            })
            ->editColumn('duration', function ($announcement) {
                $end =Carbon::createFromTimestampMs($announcement->announcementEndDate);
                $start =Carbon::createFromTimestampMs($announcement->announcementStartDate);
                return $announcement->announcementEndDate ? with( $end->diffInDays($start) .'D : '.$end->diff($start)->format('%H').'H'  ) : '';
            })
            ->editColumn('updated_at', function ($announcement) {
                return $announcement->updated_at ? with(new Carbon($announcement->created_at))->format('Y-m-d H:i') : '';
            })
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Announcement $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Announcement $model)
    {
        return $model->newQuery();
    }

    public function lang()
    {

        $langJson = [
            "sEmptyTable"     =>  trans('app.datatable.sEmptyTable'),
            "sInfo"           =>  trans('app.datatable.sInfo'),
            "sInfoEmpty"      =>  trans('app.datatable.sInfoEmpty'),
            "sInfoFiltered"   =>  trans('app.datatable.sInfoFiltered'),
            "sInfoPostFix"    =>  trans('app.datatable.sInfoPostFix'),
            "sInfoThousands"  =>  trans('app.datatable.sInfoThousands'),
            "sLengthMenu"     =>  trans('app.datatable.sLengthMenu'),
            "sLoadingRecords" =>  trans('app.datatable.sLoadingRecords'),
            "sProcessing"     =>  trans('app.datatable.sProcessing'),
            "sSearch"         =>  trans('app.datatable.sSearch'),
            "sZeroRecords"    =>  trans('app.datatable.sZeroRecords'),
            "sFirst"          =>  trans('app.datatable.sFirst'),
            "sLast"           =>  trans('app.datatable.sLast'),
            "sNext"           =>  trans('app.datatable.sNext'),
            "sPrevious"       =>  trans('app.datatable.sPrevious'),
            "sSortAscending"  =>  trans('app.datatable.sSortAscending'),
            "sSortDescending" =>  trans('app.datatable.sSortDescending'),
        ];
        return $langJson;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('announcements-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('lBfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('create')->text(' <i class="fas fa-plus-circle"></i> ' . trans('app.datatable.create-announcement')),
                // Button::make('create')
                // ->action("window.location = '".route('admin.audience.create')."';")
                // ->text(' <i class="fas fa-plus-circle"></i> ' . trans('app.datatable.create-audience')),
                Button::make('reset')->text(' <i class="fas fa-redo"></i> ' . trans('app.datatable.reset')),
                Button::make('reload')->text(' <i class="fas fa-sync-alt"></i> ' . trans('app.datatable.reload'))
            )->parameters([
                'responsive' => true,
                'autoWidth' => false,
                'lengthMenu' => [[10, 25, 50, 100], ['10', '25', '50', '100']],
                'language' => $this->lang(),
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('DT_RowIndex')->title('#')
                ->addClass('text-center'),
            Column::make('description')->title(trans('app.announcement.description')),
            Column::make('announcementStartDate')->title(trans('app.announcement.start-date')),
            Column::computed('duration')->title(trans('app.announcement.duration'))
                ->addClass('text-center'),
            Column::make('created_at')->title(trans('app.created-at')),
            Column::computed('Action')->title('Action')
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->searchable(false)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Announcements_' . date('YmdHis');
    }
}
