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
        public string $color = 'black',
        public string $padding = '',
        public int $fontSize = 18,
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
