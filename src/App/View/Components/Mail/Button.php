<?php

namespace App\View\Components\Mail;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $href,
        public string $fontFamily = 'Helvetica, Arial, sans-serif',
        public string $align = 'left',
        public string $color = 'black',
        public string $padding = '0 20px 0 20px',
        public int $fontSize = 20,
        public int $fontWeight = 300,
        public string $cssClass = ''
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.mail.button');
    }
}
