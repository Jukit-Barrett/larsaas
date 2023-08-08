<?php

namespace App\Repositories;

use Mrzkit\LaravelEloquentEnhance\CrudRepository;
use App\Models\{{RNT}};

final class {{RNT}}Repository extends CrudRepository
{
    public function __construct({{RNT}} ${{RNT}})
    {
        $this->setModel(${{RNT}});
    }

}
