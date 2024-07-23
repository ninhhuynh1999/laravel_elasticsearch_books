<?php

namespace App\Services\Contracts;

use App\Classes\DTO\PaginationResult;
use Illuminate\Http\Request;

interface ProductServiceInterface extends BaseCrudServiceInterface
{
    public function getProductForIndex(Request $request): PaginationResult;
}
