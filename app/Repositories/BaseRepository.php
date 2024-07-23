<?php

namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;
use App\Exceptions\Repository\RepositoryException;
use App\Traits\Crudable;
use App\Traits\Queryable;
use App\Repositories\Contracts\BaseRepositoryInterface;

/**
 * Class BaseRepository
 */
abstract class BaseRepository implements BaseRepositoryInterface
{
    use Crudable, Queryable;

    /**
     * Resolve model by key or return the model instance back
     *
     * @param $keyOrModel
     * @return Model
     * @throws RepositoryException
     */
    public function resolveModel($keyOrModel): Model
    {
        if ($keyOrModel instanceof Model) {
            $modelClass = $this->getModelClass();
            if (!$keyOrModel instanceof $modelClass) {
                throw new RepositoryException("Model is not an entity of repository model class");
            }
            return $keyOrModel;
        }

        return $this->findOrFail($keyOrModel);
    }

    /**
     * Check if model is instance of SoftDeletes trait
     *
     * @param Model|null $model
     * @return bool
     */
    protected function isInstanceOfSoftDeletes(Model $model = null): bool
    {
        $model = $model ?? app($this->getModelClass());

        return in_array(SoftDeletes::class, class_uses_recursive($model));
    }


    /**
     * Get model class
     *
     * @return string
     */
    abstract protected function getModelClass(): string;
}
