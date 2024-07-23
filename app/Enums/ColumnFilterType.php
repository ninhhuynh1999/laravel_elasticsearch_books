<?php

namespace App\Enums;

enum ColumnFilterType: string
{
    case NUMBER = 'number';
    case STRING = 'string';
    case DATE = 'date';
    case TERM = 'term';
    case BOOL = 'bool';
}
