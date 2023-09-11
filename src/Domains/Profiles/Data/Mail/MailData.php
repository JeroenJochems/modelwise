<?php

namespace Domain\Profiles\Data\Mail;

use App\Notifications\SidemailData\Templates;
use Domain\Profiles\Models\Model;
use Spatie\LaravelData\Data;

class MailData extends Data
{
    public function __construct(
        public Model $model,
        public Templates $template,
        public $props = null,
    ) {}
}
