<?php

namespace App\Support\Factories;

class RepositoryFactory
{

    public static function getSystemHeaderRepository(): \App\Repositories\SystemHeaderRepository
{
    return app(\App\Repositories\SystemHeaderRepository::class);
}

//{{HERE}}


}
