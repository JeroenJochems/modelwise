<?php

namespace App\View\Components\Mail;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Heading extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $fontFamily = 'sans-serif',
        public string $align = 'center',
        public string $color = '#343434',
        public string $padding = '',
        public int $fontSize = 24,
        public int $fontWeight = 500,
        public string $cssClass = '',
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.mail.heading');
    }
}
