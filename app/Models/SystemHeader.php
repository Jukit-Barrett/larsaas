<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mrzkit\LaravelEloquentEnhance\EnhanceModel;

final class SystemHeader extends EnhanceModel
{
    use HasFactory, SoftDeletes;

    /**
     * 可以批量赋值的属性
     *
     * @var array
     */
    protected $fillable = [
        'id', 'system_id', 'header_key', 'header_val', 'status', 'unique_column', 'sort', 'created_at', 'updated_at', 'deleted_at',
    ];

}
