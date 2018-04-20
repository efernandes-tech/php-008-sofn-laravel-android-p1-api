<?php

namespace SON\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use SON\Models\Category;
use SON\Presenters\CategoryPresenter;

/**
 * Class CategoryRepositoryEloquent
 * @package namespace SON\Repositories;
 */
class CategoryRepositoryEloquent extends BaseRepository implements CategoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Category::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter()
    {
        return CategoryPresenter::class;
    }

    public function applyMultitenancy()
    {
        Category::clearBootedModels();
    }

    protected function callScope(callable $scope, $parameters = [])
    {
        array_unshift($parameters, $this);

        $query = $this->getQuery();

        // We will keep track of how many wheres are on the query before running the
        // scope so that we can properly group the added scope constraints in the
        // query as their own isolated nested where statement and avoid issues.
        $originalWhereCount = count(
            ! is_null($query->wheres)
            ? $query->wheres
            : []
        );

        $result = $scope(...array_values($parameters)) ?: $this;

        if ($this->shouldNestWheresForScope($query, $originalWhereCount)) {
            $this->nestWheresForScope($query, $originalWhereCount);
        }

        return $result;
    }
}
