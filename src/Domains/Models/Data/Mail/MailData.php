<?php

namespace Domain\Models\Data\Mail;

use Domain\Models\Data\Templates;
use Domain\Models\Models\Model;
use Spatie\LaravelData\Data;

class MailData extends Data
{
    public function __construct(
        public Model $model,
        public Templates $template,
        public ?MailableData $props = null,
    ) {}
}
