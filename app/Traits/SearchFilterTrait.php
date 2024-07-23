<?php

declare(strict_types=1);

namespace App\Traits;

use App\Classes\ColumnFilter;
use App\Classes\RequestSearch;
use App\Enums\ColumnFilterType;
use Elastic\ScoutDriverPlus\Builders\BoolQueryBuilder;
use Elastic\ScoutDriverPlus\Support\Query;
use Laravel\Scout\Builder;

trait SearchFilterTrait
{
    /**
     * @param array<ColumnFilter> $columnSearch
     */
    public function searchFilter(array $filters, array $columnSearch = []): null | BoolQueryBuilder
    {
        $query = null;

        foreach ($filters as $field => $value) {
            $parts = explode(':', $field); // Split field by colon (:)
            $column = $parts[0]; // Column name
            $operator = isset($parts[1]) ? $parts[1] : 'eq'; // Operator (default: eq)

            if (!isset($columnSearch[$column])) continue;

            // Only init BoolQueryBuilder when at lease have one quest filter
            $query = $query ?: new BoolQueryBuilder();
            $requestSearch = $columnSearch[$column];

            if ($requestSearch->type == ColumnFilterType::STRING) {
                $this->searchByText($query, $requestSearch->column, $value, $operator);
            }
            if ($requestSearch->type == ColumnFilterType::DATE) {
                $this->searchByDate($query, $requestSearch->column, $value, $operator);
            }
            if ($requestSearch->type == ColumnFilterType::NUMBER) {
                $this->searchByNumber($query, $requestSearch->column, $value, $operator);
            }
        }

        return $query;
    }

    protected function searchByText(BoolQueryBuilder $query, string $column, string $value, string $operator): BoolQueryBuilder
    {
        $matchQuery = Query::match()->field($column)->query($value);
        return $query->must($matchQuery);
    }
    protected function searchByNumber(BoolQueryBuilder $query, string $column, string $value, string $operator): BoolQueryBuilder
    {
        switch ($operator) {
            case 'eq': // Equal
                return $query->must(Query::term()->field($column)->value($value));
            case 'gt': // Greater than
                return $query->must(Query::range()->field($column)->gt($value));
            case 'ge': // Greater than or equal to
                return $query->must(Query::range()->field($column)->gte($value));
            case 'lt': // Less than
                return $query->must(Query::range()->field($column)->lt($value));
            case 'le': // Less than or equal to
                return $query->must(Query::range()->field($column)->lte($value));
            default:
                return $query;
        }
    }
    protected function searchByDate(BoolQueryBuilder $query, string $column, string $value, string $operator): BoolQueryBuilder
    {
        switch ($operator) {
            case 'eq': // Equal
                return $query->must(Query::term()->field($column)->value($value));
            case 'gt': // Greater than
                return $query->must(Query::range()->field($column)->gt($value));
            case 'ge': // Greater than or equal to
                return $query->must(Query::range()->field($column)->gte($value));
            case 'lt': // Less than
                return $query->must(Query::range()->field($column)->lt($value));
            case 'le': // Less than or equal to
                return $query->must(Query::range()->field($column)->lte($value));
            default:
                return $query;
        }
    }
}
