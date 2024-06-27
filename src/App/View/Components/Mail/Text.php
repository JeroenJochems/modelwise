<?php

namespace App\View\Components\Mail;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Text extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $fontFamily = 'Helvetica, Arial, sans-serif',
        public string $align = 'left',
        public string $color = '#333333',
        public string $padding = '5px',
        public int $fontSize = 16,
        public int $fontWeight = 300,
        public string $cssClass = ''
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.mail.text');
    }
}
