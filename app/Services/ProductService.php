<?php

namespace App\Services;

use App\Classes\DTO\PaginationResult;
use App\Classes\RequestFilter\Models\ProductFilter;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Services\Contracts\ProductServiceInterface;
use Illuminate\Http\Request;

/**
 * @extends BaseCrudService<ProductRepositoryInterface>
 */
class ProductService extends BaseCrudService implements ProductServiceInterface
{

    public function __construct(ProductRepositoryInterface $productRepositoryInterface)
    {
        $this->repository = $productRepositoryInterface;
    }
    /**
     * Specify Repository class name
     *
     * @return string
     */
    protected function getRepositoryClass(): string
    {
        return ProductRepositoryInterface::class;
    }

    public function getProductForIndex(Request $request): PaginationResult
    {
        $inputs = $request->all();
        /*
        // example filter
        $inputs['name']  = "last word";
        $inputs['category_id']  = "1";
        $inputs['created_at:gte']  = "2023-10-19 00:00:00";
        $inputs['created_at:lte']  = "2023-10-19 23:59:59.99";
        */

        $page = (int) $request->get('page', 1);
        $perPage = (int) max($request->get('limit', 20), 100);
        $from = (int) $page * $perPage;

        $search = ProductFilter::create($inputs)->makeSearch();

        $data = $this->repository->dataForIndex($search, $perPage, $page);

        return $data;
    }
}
