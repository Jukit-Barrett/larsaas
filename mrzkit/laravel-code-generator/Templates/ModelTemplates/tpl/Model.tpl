<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mrzkit\LaravelEloquentEnhance\EnhanceModel;

final class {{RNT}} extends EnhanceModel
{
    use HasFactory, SoftDeletes;

    /**
     * 可以批量赋值的属性
     *
     * @var array
     */
    protected $fillable = [
        {{FILL_ABLE_TPL}}
    ];

}
