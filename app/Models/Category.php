<?php

namespace SON\Models;

use HipsterJazzbo\Landlord\BelongsToTenants;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Category extends Model implements Transformable
{
    use TransformableTrait;
    use BelongsToTenants;

    protected $fillable = [
        'name'
    ];

    public function callScope(callable $scope, $parameters = [])
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
