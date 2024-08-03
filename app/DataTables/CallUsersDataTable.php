<?php

namespace App\DataTables;

use App\Models\User;
use App\Models\CallUser;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class CallUsersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            
            ->editColumn('user', function (CallUser $user) {
                return view('pages/apps.user-management.call-users.columns._user', compact('user'));
            })

            ->editColumn('last_login_at', function (CallUser $user) {
                return sprintf('<div class="badge badge-light fw-bold">%s</div>', $user->last_login_at ? $user->last_login_at->diffForHumans() : $user->updated_at->diffForHumans());
            })
            // ->editColumn('type', function (CallUser $user) {
            //     return $user->type;
            // })
            ->editColumn('created_at', function (CallUser $user) {
                return $user->created_at->format('d M Y, h:i a');
            })
            ->addColumn('action', function (CallUser $user) {
                return view('pages/apps.user-management.call-users.columns._actions', compact('user'));
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(CallUser $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
        ->setTableId('users-table')
        ->columns($this->getColumns())
        ->minifiedAjax()
        ->dom('rt' . "<'row'<'col-sm-12'tr>><'d-flex justify-content-between'<'col-sm-12 col-md-5'i><'d-flex justify-content-between'p>>",)
        ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
        ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
        ->orderBy(2)
        ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/apps/user-management/users/columns/_draw-scripts.js')) . "}");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('user')->addClass('d-flex align-items-center')->title('Call User'),
            // Column::make('type')->title('User Type')->searchable(false),
            Column::make('created_at')->title('Joined Date')->addClass('text-nowrap')->searchable(false),
           
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
        return 'CallUsers_' . date('YmdHis');
    }
}
