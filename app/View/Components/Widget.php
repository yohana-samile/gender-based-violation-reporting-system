<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Widget extends Component
{
    public $value;
    public $description;
    public $progress;
    public $hint;
    public $bgColor;

    public function __construct($value, $description, $progress = null, $hint = null, $bgColor = 'bg-blue-500')
    {
        $this->value = $value;
        $this->description = $description;
        $this->progress = $progress;
        $this->hint = $hint;
        $this->bgColor = $bgColor;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widget');
    }
}
