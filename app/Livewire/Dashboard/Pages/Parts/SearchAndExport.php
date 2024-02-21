<?php

namespace App\Livewire\Dashboard\Pages\Parts;

use App\Livewire\Dashboard\Pages\Parts\Concers\HasPartSelections;
use App\Models\Part;
use Livewire\Component;

class SearchAndExport extends Component
{
    use HasPartSelections;

    public bool $showForm = false;

    public null|string $search = null;

    public function render()
    {
        return view('livewire/dashboard/pages/parts/search-and-export', [
            'parts' => filled($this->search) ? Part::query()
                ->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('number', 'like', '%' . $this->search . '%')
                ->orWhere('location', 'like', '%' . $this->search . '%')
                ->latest()
                ->limit(20)
                ->get() : collect(),
        ]);
    }

    public function resetForm()
    {
        $this->showForm = false;
        $this->search = null;
    }
}
