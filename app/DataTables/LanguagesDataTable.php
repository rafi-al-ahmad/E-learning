<?php

namespace App\DataTables;

use App\Models\Language;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LanguagesDataTable extends DataTable
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
            ->addColumn('Action', 'Admin.languages.Action')
            ->rawColumns([
                'Action',
            ])
            ->setRowId(function ($lang) {
                return 'row_' . $lang->id;
            })
            ->editColumn('created_at', function ($lang) {
                return $lang->created_at ? with(new Carbon($lang->created_at))->format('Y-m-d H:i') : '';
            })
            ->editColumn('updated_at', function ($lang) {
                return $lang->updated_at ? with(new Carbon($lang->created_at))->format('Y-m-d H:i') : '';
            })
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Language $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Language $model)
    {
        return $model->newQuery();
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
            ->setTableId('languages-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('lBfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('create')->text(' <i class="fas fa-plus-circle"></i> '.trans('app.datatable.create-language')),
                Button::make('excel')->text(' <i class="far fa-file-excel"></i> '.trans('app.datatable.excel')),
                Button::make('print')->text(' <i class="fas fa-print"></i> '.trans('app.datatable.print')),
                Button::make('reset')->text(' <i class="fas fa-redo"></i> '.trans('app.datatable.reset')),
                Button::make('reload')->text(' <i class="fas fa-sync-alt"></i> '.trans('app.datatable.reload'))
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
            Column::make('name')->title(trans('app.language.name')),
            Column::make('code')->title(trans('app.language.code')),
            Column::make('description')->title(trans('app.language.description')),
            Column::make('created_at')->title(trans('app.created-at')),
            Column::make('updated_at')->title(trans('app.updated-at')),
            Column::computed('Action')
                ->title('Action')
                ->exportable(false)
                ->printable(false)
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
        return 'Languages_' . date('YmdHis');
    }
}
