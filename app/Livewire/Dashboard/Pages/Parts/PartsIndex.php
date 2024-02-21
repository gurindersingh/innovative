<?php

namespace App\Livewire\Dashboard\Pages\Parts;

use App\Models\Part;
use Livewire\Component;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;
use App\Livewire\Dashboard\Pages\Parts\Concers\HasPartSelections;

class PartsIndex extends Component
{
    use WithPagination;
    use HasPartSelections;

    public ?Part $editPart = null;

    public bool $addNew = false;

    #[Url]
    public ?string $search = null;

    #[Validate([
        'form' => 'required',
        'form.name' => 'required|string',
        'form.number' => 'required|string',
        'form.unit_price' => 'required',
        'form.quantity' => 'required|integer',
        'form.location' => 'required|string',
        'form.active' => 'required|boolean',
    ])]
    public array $form = [
        'name' => '',
        'number' => '',
        'unit_price' => '',
        'quantity' => '',
        'location' => '',
        'active' => '',
    ];

    public function render()
    {
        return view('livewire.dashboard.pages.parts.parts-index', [
            'parts' => $this->getParts(),
        ]);
    }

    protected function getParts()
    {
        $query = Part::query()->with(['addedBy:id,name'])
            ->when($this->search, function (Builder $builder, $search) {
                $builder
                    ->where('name', 'like', '%' . $search . '%')
                    ->orWhere('number', 'like', '%' . $search . '%')
                    ->orWhere('location', 'like', '%' . $search . '%');
            });


        return $query->simplePaginate(20);
    }

    public function edit($partId)
    {
        $this->addNew = false;
        $this->editPart = Part::whereId($partId)->firstOrFail();
        $this->form = $this->editPart->toArray();
    }

    public function resetForm()
    {
        $this->editPart = null;
        $this->addNew = false;
        $this->form = [
            'name' => '',
            'number' => '',
            'unit_price' => '',
            'quantity' => '',
            'location' => '',
            'active' => '',
        ];
    }

    public function showCreateForm()
    {
        $this->resetForm();
        $this->addNew = true;
    }

    public function create()
    {
        $this->validate();

        if (Part::query()->where('number', $this->form['number'])->exists()) {
            throw ValidationException::withMessages([
                'form.number' => 'Part with same number already exists.'
            ]);
        }

        Part::query()->create([
            'name' => $this->form['name'],
            'number' => $this->form['number'],
            'unit_price' => (float)$this->form['unit_price'],
            'quantity' => (int)$this->form['quantity'],
            'location' => $this->form['location'],
            'active' => $this->form['active'],
            'added_by' => Auth::user()->id,
        ]);

        $this->reset();

        $this->dispatch('flash-message', data: ['type' => 'success', 'message' => 'Part created!']);
    }

    public function update()
    {
        $this->validate();

        if (Part::query()->where('number', $this->form['number'])->where('id', '!=', $this->editPart->id)->exists()) {
            throw ValidationException::withMessages([
                'form.number' => 'Part with same number already exists.'
            ]);
        }

        $this->editPart->update([
            'name' => $this->form['name'],
            'number' => $this->form['number'],
            'unit_price' => (float)$this->form['unit_price'],
            'quantity' => (int)$this->form['quantity'],
            'location' => $this->form['location'],
            'active' => $this->form['active'],
        ]);

        $this->reset();

        $this->dispatch('flash-message', data: ['type' => 'success', 'message' => 'Part updated!']);
    }

    public function import($data)
    {
        $result = collect($data['content'])
            ->map(function ($item) {
                try {
                    $v = Validator::make($item, [
                        'name' => 'required|string',
                        'number' => 'required|string',
                        'unit_price' => 'required',
                        'quantity' => 'required|integer',
                        'location' => 'required|string',
                        'active' => 'required|boolean',
                    ]);

                    return $v->passes() ? [
                        'name' => $item['name'],
                        'number' => $item['number'],
                        'unit_price' => ((float)$item['unit_price'] * 100),
                        'quantity' => (int)$item['quantity'],
                        'location' => $item['location'],
                        'active' => $item['active'],
                        'added_by' => Auth::user()->id,
                    ] : null;
                } catch (\Throwable $th) {
                    return null;
                }
            });

        // Json is not valid, notify the user
        if ($result->filter(fn ($item) => is_null($item))->count() > 0) {
            $this->dispatch('flash-message', data: ['type' => 'error', 'message' => 'Invalid format!']);
            return;
        }

        Part::query()
            ->upsert(
                $result->toArray(),
                ['number'],
            );

        $this->dispatch('flash-message', data: ['type' => 'success', 'message' => 'Data imported!']);
    }

    public function deletePart($partId)
    {
        Part::query()->whereId($partId)->firstOrFail()->delete();

        $this->dispatch('flash-message', data: ['type' => 'success', 'message' => 'Part deleted!']);
    }

    public function logout()
    {
        Auth::logout();

        session()->regenerate();

        $this->redirect(route('home'));
    }
}
