<?php

namespace App\Support\Factories;

use App\Repositories\ActivityRepository;
use App\Repositories\SystemHeaderRepository;

class RepositoryFactory
{
    //
    public static function getActivityRepository(): ActivityRepository
    {
        return app(ActivityRepository::class);
    }

    //
    public static function getSystemHeaderRepository(): SystemHeaderRepository
    {
        return app(SystemHeaderRepository::class);
    }

}
