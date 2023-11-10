<?php

namespace Domain\Jobs\Data;

use Spatie\LaravelData\Data;

/** @typescript */
class FieldsData extends Data {
    public bool $digitals;
    public bool $height;
    public bool $chest;
    public bool $waist;
    public bool $hips;
    public bool $shoe_size;
    public bool $clothing_size_top;
    public bool $head;
}
