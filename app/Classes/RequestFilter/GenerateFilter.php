<?php

namespace App\Classes\RequestFilter;

use App\Classes\ColumnFilter;
use App\Enums\ColumnFilterType;
use Carbon\Carbon;
use DateTimeImmutable;
use DateTimeZone;
use Elastic\ScoutDriverPlus\Builders\BoolQueryBuilder;
use Elastic\ScoutDriverPlus\Support\Query;

class GenerateFilter
{
    public const START = 0;
    public const SIZE = 20;
    public const MAX_SIZE = 100;

    /**
     * @var array<string, string>
     */
    protected array $request;

    /**
     * @var array<ColumnFilter>
     */
    protected array $columnSearch;

    public function __construct(array $_request, array $_columnSearch)
    {
        $this->request = $_request;
        $this->columnSearch = $_columnSearch;
    }

    public function makeSearch(): null | BoolQueryBuilder
    {
        $query = null;

        foreach ($this->request as $field => $value) {
            $parts = explode(':', $field); // Split field by colon (:)
            $column = $parts[0]; // Column name
            $operator = isset($parts[1]) ? $parts[1] : 'eq'; // Operator (default: eq)

            if (!isset($this->columnSearch[$column])) continue;

            // Only init BoolQueryBuilder when at lease have one filter
            $query = $query ?: new BoolQueryBuilder();
            $requestSearch = $this->columnSearch[$column];


            switch ($requestSearch->type) {
                case ColumnFilterType::STRING:
                    $this->searchByText($query, $requestSearch->column, $value);
                    break;
                case ColumnFilterType::TERM:
                    $this->searchByTerm($query, $requestSearch->column, $value);
                    break;
                case ColumnFilterType::BOOL:
                    $this->searchByBoolean($query, $requestSearch->column, $value);
                    break;
                case ColumnFilterType::DATE:
                    $this->searchByDate($query, $requestSearch->column, $value, $operator);
                    break;
                case ColumnFilterType::NUMBER:
                    $this->searchByNumber($query, $requestSearch->column, $value, $operator);
                    break;
                default:
                    break;
            }
        }

        return $query;
    }

    protected function searchByText(BoolQueryBuilder &$query, string $column, string $value): BoolQueryBuilder
    {
        $matchQuery = Query::match()->field($column)->query($value);
        return $query->must($matchQuery);
    }

    protected function searchByTerm(BoolQueryBuilder &$query, string $column, string $value): BoolQueryBuilder
    {
        $matchQuery = Query::term()->field($column)->value($value);
        return $query->must($matchQuery);
    }

    protected function searchByBoolean(BoolQueryBuilder &$query, string $column, bool $value): BoolQueryBuilder
    {
        $matchQuery = Query::term()->field($column)->value($value);
        return $query->must($matchQuery);
    }

    protected function searchByNumber(BoolQueryBuilder &$query, string $column, string $value, string $operator): BoolQueryBuilder
    {
        switch ($operator) {
            case 'eq': // Equal
                return $query->must(Query::term()->field($column)->value($value));
            case 'gt': // Greater than
                return $query->must(Query::range()->field($column)->gt($value));
            case 'gte': // Greater than or equal to
                return $query->must(Query::range()->field($column)->gte($value));
            case 'lt': // Less than
                return $query->must(Query::range()->field($column)->lt($value));
            case 'lte': // Less than or equal to
                return $query->must(Query::range()->field($column)->lte($value));
            default:
                return $query;
        }
    }

    protected function searchByDate(BoolQueryBuilder &$query, string $column, string $value, string $operator): BoolQueryBuilder
    {
        $datetime = date_create_from_format('Y-m-d H:i:s', $value, new DateTimeZone('UTC'));
        if (!$datetime) $datetime = date_create_from_format('Y-m-d H:i:s.u', $value, new DateTimeZone('UTC'));
        if (!$datetime) return $query;

        $formattedDatetime = $datetime->format('Y-m-d\TH:i:s.up');

        switch ($operator) {
            case 'eq': // Equal
                return $query->must(Query::term()->field($column)->value($formattedDatetime));
            case 'gt': // Greater than
                return $query->must(Query::range()->field($column)->gt($formattedDatetime));
            case 'gte': // Greater than or equal to
                return $query->must(Query::range()->field($column)->gte($formattedDatetime));
            case 'lt': // Less than
                return $query->must(Query::range()->field($column)->lt($formattedDatetime));
            case 'lte': // Less than or equal to
                return $query->must(Query::range()->field($column)->lte($formattedDatetime));
            default:
                return $query;
        }
    }
}
