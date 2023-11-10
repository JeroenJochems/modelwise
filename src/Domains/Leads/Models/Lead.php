<?php

namespace Domain\Leads\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasShortflakePrimary;

class Lead extends Model
{
    use HasShortflakePrimary;
    use HasFactory;

}
