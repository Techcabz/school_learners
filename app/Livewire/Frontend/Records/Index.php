<?php

namespace App\Livewire\Frontend\Records;

use Livewire\Component;

class Index extends Component
{
    public $page = 'front';

    public function showTemplate($type)
    {
        $this->page = $type;
    }
    
    public function render()
    {
        return view('livewire.frontend.records.index');
    }
}
