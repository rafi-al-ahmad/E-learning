<?php

namespace App\DataTables;

use App\Models\User;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
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
            ->addColumn('Action', 'Admin.users.action')
            ->rawColumns([
                'Action',
            ])
            ->setRowId(function ($user) {
                return 'row_' . $user->id;
            })
            ->editColumn('created_at', function ($user) {
                return $user->created_at ? with(new Carbon($user->created_at))->format('Y-m-d H:i') : '';
            })
            ->editColumn('personal-details', function ($user) {
                return $user->getFullName();
            })
            ->editColumn('role', function ($user) {
                return $user->getRoleName();
            })
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        // dd($model->newQuery());
        return User::query();
    }

    public function lang()
    {

        $langJson =[
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
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('lBfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('reset')->text(' <i class="fas fa-redo"></i> '.trans('app.datatable.reset')),
                Button::make('reload')->text(' <i class="fas fa-sync-alt"></i> '.trans('app.datatable.reload')),
            )->parameters([
                'responsive' => true,
                'autoWidth' => false,
                'lengthMenu' => [[10, 25, 50, 100, 500], ['10', '25', '50', '100', '500']],

                'language' => $this->lang(),

                // 'initComplete' => "function () {
                //     this.api().columns([1,2]).every(function () {
                //         var column = this;
                //         var input = document.createElement(\"input\");
                //         $(input).appendTo($(column.footer()).empty())
                //         .on('change', function () {
                //             column.search($(this).val(), false, false, true).draw();
                //         });
                //     });
                // }",

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
            Column::make('user_name')->title(trans('app.users.user-name')),
            Column::make('email')->title(trans('app.users.email')),
            Column::make('personal-details')->title(trans('app.users.full-name'))
                ->searchable(false),
            Column::make('role')->title(trans('app.users.role'))
                ->searchable(false),
            Column::make('created_at')->title(trans('app.created-at'))
                ->searchable(false),
            Column::computed('Action')->title('Action')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center')
                ->searchable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Users_' . date('YmdHis');
    }
}
