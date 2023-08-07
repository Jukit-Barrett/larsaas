<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mrzkit\LaravelEloquentEnhance\EnhanceModel;

class Activity extends EnhanceModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'ch_activity';

    protected $fillable = [
        "id", "system_id", "community_id", "name", "description", "created_at", "updated_at", "deleted_at",
    ];

}
