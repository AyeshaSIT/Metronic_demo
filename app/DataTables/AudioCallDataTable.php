<?php

namespace App\DataTables;

use App\Models\AudioCall;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class AudioCallDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->editColumn('name', function (AudioCall $audiocall) {
            return $audiocall->name;
        })
        // ->editColumn('audio', function (AudioCall $audiocall) {
        //     return '<audio controls> <source src="' . asset('storage'.$audiocall->file_path) . '" type="audio/mpeg"></audio>';
        // })
        // ->editColumn('audio', function (AudioCall $audiocall) {
        //     $audioUrl = Storage::url($audiocall->file_path);
        //     return $audioUrl;
        //     // return '<audio controls> <source src="' . $audioUrl . '" type="audio/mpeg"></audio>';
        // })
    
        ->editColumn('created_at', function (AudioCall $audiocall) {
            return $audiocall->created_at->format('d M Y, h:i a');
        })
        ->addColumn('action', function (AudioCall $audiocall) {
            return view('pages/call-insights.data-management.audiocalls.columns._actions', compact('audiocall'));
            
        })
        ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(AudioCall $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        
        return $this->builder()
        ->setTableId('audiocall-table')
        ->columns($this->getColumns())
        ->minifiedAjax()
        ->dom('rt' . "<'row'<'col-sm-12'tr>><'d-flex justify-content-between'<'col-sm-12 col-md-5'i><'d-flex justify-content-between'p>>",)
        ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
        ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
        ->orderBy(2)
        ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/call-insights/data-management/audiocalls/columns/_draw-scripts.js')) . "}");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {

        return [
            Column::make('name')->addClass('d-flex align-items-center')->title('File Name'),
            // Column::make('audio')->title('Audio')->searchable(false),
            Column::make('created_at')->title('Date')->addClass('text-nowrap'),
           
            Column::computed('action')
                ->addClass('text-end text-nowrap')
                ->exportable(false)
                ->printable(false)
                ->width(60)
            ];
    }


    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'AudioCall_' . date('YmdHis');
    }
}
