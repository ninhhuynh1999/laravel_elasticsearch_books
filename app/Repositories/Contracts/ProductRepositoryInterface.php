<?php

namespace App\Repositories\Contracts;

use App\Classes\DTO\PaginationResult;
use App\Repositories\Contracts\BaseRepositoryInterface;
use Elastic\ScoutDriverPlus\Builders\BoolQueryBuilder;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    public function dataForIndex(BoolQueryBuilder | array | null $search, int $perPage, ?int $page): PaginationResult;
}
