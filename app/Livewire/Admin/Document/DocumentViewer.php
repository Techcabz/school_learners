<?php

namespace App\Livewire\Admin\Document;

use Livewire\Component;

class DocumentViewer extends Component
{
    public $page = 'front';

    public function showTemplate($type)
    {
        $this->page = $type;
    }
    
    public function render()
    {
        return view('livewire.admin.document.document-viewer');
    }
}
