<?php

namespace App\Support\Factories;

use App\Repositories\ActivityRepository;

class RepositoryFactory
{
    //
    public static function getActivityRepository(): ActivityRepository
    {
        return app(ActivityRepository::class);
    }


}
