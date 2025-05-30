<?php

namespace App\DataTables;

use App\Models\KategoriModel;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class KategoriDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                return '<a href="' . route('kategori.edit', $row->kategori_id) . '" class="btn btn-sm btn-primary">
                    <i class="fa fa-pencil-alt"></i>
                </a>';
            })
            ->addColumn('delete', function ($row) {
                return '<button class="btn btn-sm btn-danger btn-delete" data-toggle="modal" data-target="#modalHapus" data-id="' . $row->kategori_id . '">
                    <i class="fa fa-trash"></i>
                </button>';
            })



            ->rawColumns(['action', 'delete']) // Agar tombol HTML bisa dirender dengan benar
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(KategoriModel $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('kategori-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            /*         Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'), */
            Column::make('kategori_id')
                ->addClass('text-center'),
            Column::make('kategori_kode')
                ->addClass('text-center'),
            Column::make('kategori_nama')
                ->addClass('text-center'),
            Column::make('created_at')
                ->addClass('text-center'),
            Column::make('updated_at')
                ->addClass('text-center'),
            Column::computed('action') // Tambahkan kolom aksi
                ->exportable(false)
                ->printable(false)
                ->width(50)
                ->addClass('text-center')
                ->title('Edit'),
            Column::computed('delete') // Tambahkan kolom aksi
                ->exportable(false)
                ->printable(false)
                ->width(50)
                ->addClass('text-center')
                ->title('Delete'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Kategori_' . date('YmdHis');
    }
}
