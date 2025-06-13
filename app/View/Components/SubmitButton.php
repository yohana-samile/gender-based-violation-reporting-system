<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SubmitButton extends Component
{
    public $icon, $label, $showClose, $closeType, $closeTarget, $buttonClass;

    public function __construct(
        $icon = 'fas fa-save',
        $label = 'Save',
        $showClose = false,
        $closeType = 'modal',
        $closeTarget = null,
        $buttonClass = 'bg-indigo-500' // default class
    ) {
        $this->icon = $icon;
        $this->label = $label;
        $this->showClose = $showClose;
        $this->closeType = $closeType;
        $this->closeTarget = $closeTarget;
        $this->buttonClass = $buttonClass;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.submit-button');
    }
}
