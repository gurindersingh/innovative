<?php

namespace App\Livewire\Dashboard\Pages\Parts\Concers;

use App\Models\Part;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Collection;

trait HasPartSelections
{
    public array $partSelection = [];

    public function addToSelection($data)
    {
        $selections = collect($this->partSelection);
        $newAddition = collect(collect($data['ids'] ?? []));

        $this->partSelection = $newAddition->concat($selections)->unique()->toArray();
    }

    public function clearSelection()
    {
        $this->partSelection = [];
    }

    public function export()
    {
        if (!$parts = $this->getPartsBySelection()) return;

        return response()
            ->streamDownload(function () use ($parts) {
                echo $parts;
            }, 'parts-' . Str::ulid() . '.json');
    }

    public function exportPdf()
    {
        if (!$parts = $this->getPartsBySelection()) return;

        $pdf = Pdf::loadView('stubs.export-part', ['parts' => $parts])->setPaper('a4', 'portrait');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'parts-' . Str::ulid() . '.pdf');
    }



    public function exportCsv()
    {
        if (!$parts = $this->getPartsBySelection()) return;

        $csvExporter = new \Laracsv\Export();

        $csv = $csvExporter->build($parts, ['id', 'name', 'number', 'location']);

        return response()->streamDownload(function () use ($csv) {
            echo $csv->getWriter()->toString();
        }, 'parts-' . Str::ulid() . '.csv');
    }

    public function getPartsBySelection(): ?Collection
    {
        $selections = collect($this->partSelection);

        if ($selections->isEmpty()) {
            $this->dispatch('flash-message', data: ['type' => 'error', 'message' => 'Nothing to export!']);
            return null;
        }

        return Part::query()->whereIn('id', $selections->toArray())->get();;
    }
}
