<?php

namespace App\Classes\RequestFilter;

use App\Enums\ColumnFilterType;

class ColumnFilter
{
    public string $name;
    public string $column;
    public ColumnFilterType $type;

    public function __construct(string $name, string $column, ColumnFilterType $type)
    {
        $this->name = $name;
        $this->column = $column;
        $this->type = $type;
    }

    public static function create(string $name, string $column, ColumnFilterType $type)
    {
        return new self($name, $column, $type);
    }
}
