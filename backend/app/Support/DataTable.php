<?php

namespace App\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class DataTable
{
    /**
     * @var array<string, string>
     */
    protected array $columns = [];

    /**
     * @var Collection<int, array<string, mixed>>
     */
    protected Collection $rows;

    /**
     * @param array<string, string> $columns  column key => display label
     * @param Collection<int, array<string, mixed>> $rows
     */
    public function __construct(array $columns, Collection $rows)
    {
        $this->columns = $columns;
        $this->rows = $rows;
    }

    /**
     * Render the table HTML.
     */
    public function table(): HtmlString
    {
        $html = '<table class="table table-bordered data-table">
            <thead>
                <tr>';
        foreach ($this->columns as $label) {
            $html .= '<th>' . e($label) . '</th>';
        }
        $html .= '</tr>
            </thead>
            <tbody>';
        foreach ($this->rows as $row) {
            $html .= '<tr>';
            foreach (array_keys($this->columns) as $key) {
                $value = $row[$key] ?? '';
                $html .= '<td>' . e($value) . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody>
        </table>';

        return new HtmlString($html);
    }

    /**
     * Render the datatable initialization scripts.
     */
    public function scripts(): HtmlString
    {
        return new HtmlString('<script>
            $(document).ready(function () {
                $(".data-table").DataTable();
            });
        </script>');
    }
}
