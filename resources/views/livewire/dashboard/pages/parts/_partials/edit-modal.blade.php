@if ($editPart?->id || $addNew)
    <div class="fixed inset-0 flex flex-col items-center pt-20 bg-black/10 md:pt-40">

        <div
            class="w-full max-w-screen-md bg-white rounded-lg shadow"
            wire:click.outside="resetForm"
        >
            <div class="px-6 py-3 border-b">
                <h2 class="text-2xl">
                    {{ $editPart?->id ? 'Edit part' : 'Add part' }}
                </h2>
            </div>

            <form
                action="#"
                class="p-6"
                wire:submit="{{ $editPart?->id ? 'update' : 'create' }}"
            >

                <div class="grid grid-cols-2 gap-6">

                    <div class="flex flex-col w-full">
                        <x-form.label>Part name</x-form.label>
                        <x-form.input
                            type="text"
                            wire:model="form.name"
                            required
                            name="part_name"
                        />
                        <x-form.error :error="$errors->first('form.name')" />
                    </div>

                    <div class="flex flex-col w-full">
                        <x-form.label>Part number</x-form.label>
                        <x-form.input
                            type="text"
                            wire:model="form.number"
                            required
                            name="part_number"
                        />
                        <x-form.error :error="$errors->first('form.number')" />
                    </div>

                    <div class="flex flex-col w-full">
                        <x-form.label>Unit price</x-form.label>
                        <x-form.input
                            type="number"
                            wire:model="form.unit_price"
                            required
                            name="unit_price"
                        />
                        <x-form.error :error="$errors->first('form.unit_price')" />
                    </div>

                    <div class="flex flex-col w-full">
                        <x-form.label>Quantity</x-form.label>
                        <x-form.input
                            type="number"
                            wire:model="form.quantity"
                            required
                            name="quantity"
                        />
                        <x-form.error :error="$errors->first('form.quantity')" />
                    </div>

                    <div class="flex flex-col w-full">
                        <x-form.label>Location</x-form.label>
                        <x-form.input
                            type="text"
                            wire:model="form.location"
                            required
                            name="location"
                        />
                        <x-form.error :error="$errors->first('form.location')" />
                    </div>

                    <div class="flex flex-col w-full">
                        <x-form.label>Status</x-form.label>
                        <div class="">
                            <input
                                type="checkbox"
                                wire:model="form.active"
                            /> <span class="ml-1"> Active</span>
                        </div>
                        <x-form.error :error="$errors->first('form.active')" />
                    </div>

                </div>

                <div class="flex items-center justify-between mt-4">
                    <button
                        type="button"
                        wire:click="resetForm()"
                        class="py-4"
                    >Close</button>

                    <x-form.button
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:loading.class="animate-pulse"
                    > {{ $editPart?->id ? 'Update' : 'Create' }}</x-form.button>
                </div>

            </form>
        </div>

    </div>
@endif
