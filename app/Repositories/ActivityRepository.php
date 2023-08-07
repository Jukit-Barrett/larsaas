<?php

namespace App\Repositories;

use App\Models\Activity;
use Mrzkit\LaravelEloquentEnhance\CrudRepository;

class ActivityRepository extends CrudRepository
{
    public function __construct(Activity $model)
    {
        $this->setModel($model);
    }
}
