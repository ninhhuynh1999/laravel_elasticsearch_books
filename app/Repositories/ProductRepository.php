<?php

namespace App\Repositories;

use App\Classes\DTO\PaginationResult;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Traits\ElasticQueryable;
use Elastic\ScoutDriverPlus\Builders\BoolQueryBuilder;
use Elastic\ScoutDriverPlus\Decorators\Hit;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    protected function getModelClass(): string
    {
        return Product::class;
    }

    public function dataForIndex(BoolQueryBuilder | array | null $search, int $perPage, ?int $page): PaginationResult
    {
        $query = Product::searchQuery($search)->paginate($perPage, 'page', $page);

        $ids = [];
        $ids = array_map(function (Hit $item) {
            return $item->toArray()['document']['id'];
        }, $query->items());

        $data = $this->queryDataForIndex($ids);
        return new PaginationResult($data, $query->total(), $query->currentPage(), $query->lastPage());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<Product>
     */
    public function queryDataForIndex(array $productIds): \Illuminate\Database\Eloquent\Collection
    {
        return Product::with([
            'category',
            'supplier'
        ])->whereIn('product_id', $productIds)->get();
    }
}
