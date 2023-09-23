<?php

namespace App\Repositories;

use Mrzkit\LaravelEloquentEnhance\CrudRepository;
use App\Models\SystemHeader;

final class SystemHeaderRepository extends CrudRepository
{
    public function __construct(SystemHeader $systemHeader)
    {
        $this->setModel($systemHeader);
    }

}
