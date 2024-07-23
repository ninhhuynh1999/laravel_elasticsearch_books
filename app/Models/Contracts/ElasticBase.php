<?php

namespace App\Models\Contracts;

use Elastic\ScoutDriverPlus\Searchable;
use Illuminate\Database\Eloquent\Model;

class ElasticBase extends Model
{
    use Searchable;
}
