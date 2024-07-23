<?php

namespace App\Classes\RequestFilter\Models;

use App\Classes\RequestFilter\ColumnFilter;
use App\Classes\RequestFilter\GenerateFilter;
use App\Enums\ColumnFilterType;

class ProductFilter extends GenerateFilter
{
    public function __construct(array $_request)
    {
        $this->request = $_request;

        $this->columnSearch = [
            'category_id'    => ColumnFilter::create('category_id',    'category_id',    ColumnFilterType::NUMBER),
            'supplier_id'    => ColumnFilter::create('supplier_id',    'supplier_id',    ColumnFilterType::TERM),
            'barcode'        => ColumnFilter::create('barcode',        'barcode',        ColumnFilterType::STRING),
            'sku'            => ColumnFilter::create('sku',            'sku',            ColumnFilterType::STRING),
            'name'           => ColumnFilter::create('name',           'name',           ColumnFilterType::STRING),
            'current_stock'  => ColumnFilter::create('current_stock',  'current_stock',  ColumnFilterType::NUMBER),
            'min_stock'      => ColumnFilter::create('min_stock',      'min_stock',      ColumnFilterType::NUMBER),
            'max_stock'      => ColumnFilter::create('max_stock',      'max_stock',      ColumnFilterType::NUMBER),
            'description'    => ColumnFilter::create('description',    'description',    ColumnFilterType::STRING),
            'sale_price'     => ColumnFilter::create('sale_price',     'sale_price',     ColumnFilterType::NUMBER),
            'purchase_price' => ColumnFilter::create('purchase_price', 'purchase_price', ColumnFilterType::NUMBER),
            'is_active'      => ColumnFilter::create('is_active',      'is_active',      ColumnFilterType::STRING),
            'user_id'        => ColumnFilter::create('user_id',        'user_id',        ColumnFilterType::STRING),
            'created_at'     => ColumnFilter::create('created_at',     'created_at',     ColumnFilterType::DATE),
            'updated_at'     => ColumnFilter::create('updated_at',     'updated_at',     ColumnFilterType::DATE),
        ];
    }

    public static function create(array $_request)
    {
        return new self($_request);
    }
}
