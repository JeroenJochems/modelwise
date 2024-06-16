<?php

namespace Domain\Present\Models;

use Domain\Jobs\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kra8\Snowflake\HasShortflakePrimary;

class Presentation extends Model
{
    use HasShortflakePrimary;

    protected $guarded = [];

    protected $casts = [
        "applications" => "array",
        "should_show_casting_media" => "boolean",
        "should_show_digitals" => "boolean",
        "should_show_cover_letter" => "boolean",
        "should_show_conflicts" => "boolean",
        "should_show_socials" => "boolean",
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
