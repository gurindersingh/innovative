<div class="">
    <div class="">
        <button
            wire:click="$toggle('showForm')"
            type="button"
            class="font-semibold text-blue-500 hover:underline"
        >Search & Export</button>
    </div>

    @if ($showForm)
        <div class="fixed inset-0 z-30 flex flex-col items-center pt-12 bg-black/10">

            <div class="w-full max-w-screen-lg bg-white rounded-lg" wire:click.outside="resetForm()">

                <div class="flex items-center justify-between px-6 py-4 mb-4 border-b">
                    <h3 class="text-lg">Search & Explort</h3>

                    <div class="flex space-x-6">
                        <button
                            wire:click="$set('partSelection', {})"
                            class="font-semibold text-blue-500 hover:underline"
                        >Clear selection</button>
                        <button
                            wire:click="exportPdf"
                            class="font-semibold text-blue-500 hover:underline"
                        >Export as PDF</button>
                        <button
                            wire:click="exportCsv"
                            class="font-semibold text-blue-500 hover:underline"
                        >Export as CSV</button>
                        <button
                            wire:click="resetForm()"
                            class="font-semibold text-gray-500 hover:underline"
                        >Close</button>
                    </div>
                </div>

                <div class="px-6 pt-4 pb-6">
                    @include('livewire.dashboard.pages.parts._partials.search-form')

                    <div class="">
                        <div
                            class="w-full mt-4 overflow-x-auto overflow-y-auto border"
                            style="max-height: 500px"
                            x-data="{
                                checkAll($event) {
                                    let ids = $event.target.checked ?
                                        Array.from(document.querySelectorAll(`[data-type='partIdCheckbox']`)).map(item => item.value) : [];
                                    @this.addToSelection({ ids: ids });
                                }
                            }"
                        >
                            <table class="w-full">

                                <thead>
                                    <tr class="text-left border-b">
                                        <th class="px-4 py-2">
                                            <div class="">
                                                <input
                                                    type="checkbox"
                                                    x-on:change="checkAll"
                                                />
                                            </div>
                                        </th>
                                        <th class="py-2 pr-4">ID</th>
                                        <th class="px-4 py-2 border-l">Name</th>
                                        <th class="px-4 py-2 border-l">Number</th>
                                        <th class="px-4 py-2 border-l">Unit Price</th>
                                        <th class="px-4 py-2 border-l">Quantity</th>
                                        <th class="px-4 py-2 border-l">Location</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($parts as $part)
                                        <tr
                                            class="text-left hover:bg-slate-50 {{ !$loop->last ? 'border-b' : '' }}"
                                            wire:key="{{ $part->id }}"
                                        >
                                            <td class="px-4 py-2 whitespace-nowrap">
                                                <div class="">
                                                    <input
                                                        data-type="partIdCheckbox"
                                                        type="checkbox"
                                                        value="{{ $part->id }}"
                                                        wire:model="partSelection"
                                                    />
                                                </div>
                                            </td>
                                            <td class="py-2 pr-4 whitespace-nowrap">{{ $part->id }}</td>
                                            <td class="px-4 py-2 border-l whitespace-nowrap">{{ $part->name }}</td>
                                            <td class="px-4 py-2 border-l whitespace-nowrap">{{ $part->number }}</td>
                                            <td class="px-4 py-2 border-l whitespace-nowrap">
                                                ${{ $part->unit_price }}</td>
                                            <td class="px-4 py-2 border-l whitespace-nowrap">{{ $part->quantity }}</td>
                                            <td class="px-4 py-2 border-l whitespace-nowrap">{{ $part->location }}</td>
                                        </tr>
                                    @endforeach

                                    @if ($parts->isEmpty())
                                        <tr class="">
                                            <td
                                                class="p-4"
                                                colspan="9"
                                            >
                                                No results...
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endif
</div>
