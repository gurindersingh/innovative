<?php

use App\Models\Part;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Support\Arr;
use function Pest\Laravel\get;
use App\Livewire\Dashboard\Pages\Parts\PartsIndex;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

describe('parts_test', function () {

    it('has_parts_index_page', function () {

        get(route('parts.index'))->assertStatus(200);
    });


    it('show_list_of_parts', function () {

        Part::factory()->count(100)->create();

        $component = Livewire::test(PartsIndex::class);

        $component->assertViewHas('parts', function ($parts) {
            return get_class($parts->first()) === Part::class;
        });
    });

    it('can_create_new_part', function () {
        $part = Part::factory()->count(1)->make()->first();

        expect(Part::count())->toBe(0);

        $component = Livewire::test(PartsIndex::class);

        $component->set('form', $part->toArray());

        $component->call('create', $part->id);

        expect(Part::count())->toBe(1);

        expect(Part::first()->added_by)->toBe($this->user->id);

        $component->assertDispatched('flash-message', function ($eventName, $props) {
            return $props['data']['message'] === 'Part created!';
        });
    });

    it('update_the_part', function () {

        $part = Part::factory()->count(1)->create()->first();

        $component = Livewire::test(PartsIndex::class);

        $component->call('edit', $part->id);

        $component->assertSet('editPart.id', $part->id);
        $component->assertSet('form.name', $part->name);

        $component->set('form.name', $newName = 'new-name');

        $component->call('update');
        $component->assertSet('editPart', null);
        $component->assertSet('form.name', '');

        expect($part->refresh()->name)->toBe($newName);
    });

    it('delete_the_part', function () {

        $part = Part::factory()->count(1)->create()->first();

        $component = Livewire::test(PartsIndex::class);

        $component->call('deletePart', $part->id);

        expect(Part::query()->whereId($part->id)->first())->toBeNull();
    });

    it('can_import_the_parts', function () {
        $parts = Part::factory()->count(2)->make();

        $component = Livewire::test(PartsIndex::class);

        expect(Part::count())->toBe(0);

        $component->call('import', ['content' => $parts->toArray()]);

        expect(Part::count())->toBe(2);
    });

    it('throw_error_for_malformed_data_to_import', function () {
        $parts = Part::factory()->count(2)->make()->toArray();

        Arr::set($parts, '0.name', '');

        $component = Livewire::test(PartsIndex::class);

        expect(Part::count())->toBe(0);

        $component->call('import', ['content' => $parts]);

        $component->assertDispatched('flash-message', function ($eventName, $props) {
            return $props['data']['message'] === 'Invalid format!';
        });

        expect(Part::count())->toBe(0);
    });
});
