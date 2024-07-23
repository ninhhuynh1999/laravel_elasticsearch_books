<?php

namespace App\Classes\DTO;

use Illuminate\Database\Eloquent\Collection;

class PaginationResult
{


    public Collection $data;
    public int $total;
    public int $currentPage;
    public int|null $lastPage;

    public function __construct(Collection $data, int $total, int $currentPage, ?int $lastPage)
    {
        $this->data = $data;
        $this->total = $total;
        $this->currentPage = $currentPage;
        $this->lastPage = $lastPage;
    }
}
