<?php

use App\Models\Part;
use App\Models\User;
use Livewire\Livewire;
use App\Livewire\Dashboard\Pages\Parts\SearchAndExport;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

describe('search_and_export_test', function () {

    it('can_search_parts', function () {
        $part = Part::factory()->count(10)->create();

        $part->first()->update(['number' => 'random-number']);

        $component = Livewire::test(SearchAndExport::class);

        $component->set('search', 'random');

        $component->assertViewHas('parts', function ($parts) {
            return get_class($parts->where('number', 'random-number')->first()) === Part::class;
        });
    });

    test('it_can_export_parts_to_pdf', function () {
        $part = Part::factory()->count(10)->create();

        $component = Livewire::test(SearchAndExport::class);

        $component->set('partSelection', $part->pluck('id')->toArray());

        $component->call('exportPdf')->assertFileDownloaded();
    });


    test('it_can_export_parts_to_csv', function () {
        $part = Part::factory()->count(10)->create();

        $component = Livewire::test(SearchAndExport::class);

        $component->set('partSelection', $part->pluck('id')->toArray());

        $component->call('exportCsv')->assertFileDownloaded();
    });

});
