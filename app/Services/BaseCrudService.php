<?php

namespace App\Services;


use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;
use App\Exceptions\Repository\RepositoryException;
use App\Exceptions\Service\ServiceException;
use App\Repositories\Contracts\BaseRepositoryInterface;
use App\Services\Contracts\BaseCrudServiceInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class BaseCrudService
 * @template TRepository of BaseRepositoryInterface
 */
abstract class BaseCrudService implements BaseCrudServiceInterface
{
    /**
     * @var TRepository
     */
    protected $repository;

    /**
     * BaseCrudService constructor.
     */
    public function __construct()
    {
        $this->repository = app($this->getRepositoryClass());
    }

    /**
     * Set with for repository querying
     *
     * @param array $with
     * @return BaseCrudServiceInterface
     */
    public function with(array $with): BaseCrudServiceInterface
    {
        $this->repository->with($with);

        return $this;
    }

    /**
     * Set withCount for repository querying
     *
     * @param array $withCount
     * @return BaseCrudServiceInterface
     */
    public function withCount(array $withCount): BaseCrudServiceInterface
    {
        $this->repository->withCount($withCount);

        return $this;
    }



    /**
     * Get filtered results
     *
     * @param array $search
     * @param int $pageSize
     * @return LengthAwarePaginator
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getAllPaginated(array $search = [], int $pageSize = 15): LengthAwarePaginator
    {
        return $this->repository->getAllPaginated($search, $pageSize);
    }

    /**
     * Get all records as collection
     *
     * @param array $search
     * @return EloquentCollection
     */
    public function getAll(array $search = []): EloquentCollection
    {
        return $this->repository->getAll($search);
    }


    /**
     * Get results count
     *
     * @throws RepositoryException
     */
    public function count(array $search = []): int
    {
        return $this->repository->count($search);
    }

    /**
     * Find or fail the model
     *
     * @param $key
     * @param string|null $column
     * @return Model
     */
    public function findOrFail($key, string $column = null): Model
    {
        return $this->repository->findOrFail($key, $column);
    }

    /**
     * Find models by attributes
     *
     * @param array $attributes
     * @return Collection
     */
    public function find(array $attributes): Collection
    {
        return $this->repository->findMany($attributes);
    }

    /**
     * Create model
     *
     * @param array $data
     * @return Model|null
     * @throws ServiceException
     */
    public function create(array $data): ?Model
    {
        if (is_null($model = $this->repository->create($data))) {
            throw new ServiceException('Error while creating model');
        }

        return $model;
    }

    /**
     * Insert data into db
     *
     * @param array $data
     * @return bool
     */
    public function insert(array $data): bool
    {
        return $this->repository->insert($data);
    }

    /**
     * Create many models
     *
     * @param array $attributes
     * @return Collection
     * @throws ServiceException
     */
    public function createMany(array $attributes): Collection
    {
        if (empty($attributes)) {
            throw new ServiceException('Data is empty');
        }

        return DB::transaction(function () use ($attributes) {
            $models = collect();

            foreach ($attributes as $data) {
                $models->push($this->create($data));
            }

            return $models;
        });
    }

    /**
     * Update or create model
     *
     * @param array $attributes
     * @param array $data
     * @return Model|null
     * @throws ServiceException
     */
    public function updateOrCreate(array $attributes, array $data): ?Model
    {
        if (is_null($model = $this->repository->updateOrCreate($attributes, $data))) {
            throw new ServiceException('Error while creating or updating the model');
        }

        return $model;
    }

    /**
     * Update model
     *
     * @param $keyOrModel
     * @param array $data
     * @return Model|null
     */
    public function update($keyOrModel, array $data): ?Model
    {
        return $this->repository->update($keyOrModel, $data);
    }

    /**
     * Delete model
     *
     * @param $keyOrModel
     * @return bool
     * @throws Exception
     */
    public function delete($keyOrModel): bool
    {
        if (!$this->repository->delete($keyOrModel)) {
            throw new ServiceException('Error while deleting model');
        }

        return true;
    }

    /**
     * Delete many records
     *
     * @param array $keysOrModels
     * @return void
     */
    public function deleteMany(array $keysOrModels): void
    {
        DB::transaction(function () use ($keysOrModels) {
            foreach ($keysOrModels as $keyOrModel) {
                $this->delete($keyOrModel);
            }
        });
    }

    /**
     * Should return RepositoryInterface::class
     *
     * @return string
     */
    abstract protected function getRepositoryClass(): string;
}
