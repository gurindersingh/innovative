<div class="flex flex-col items-center w-full min-h-screen pt-12 mb-40">

    <div class="w-full max-w-screen-xl px-6">

        <div class="flex items-center justify-between mb-12">
            <div class="">
                <h1 class="text-4xl font-bold">Parts List</h1>
            </div>

            <div class="">
                <button
                    type="button"
                    class="py-2 hover:underline"
                    wire:click="logout"
                >Logout</button>
            </div>
        </div>

        <div class="flex items-center justify-between">
            @include('livewire.dashboard.pages.parts._partials.search-form')

            <div class="flex items-center justify-between space-x-6">
                <div class="">
                    <button
                        wire:click="showCreateForm"
                        type="button"
                        class="font-semibold text-blue-500 hover:underline"
                    >Add new</button>
                </div>

                @include('livewire/dashboard/pages/parts/_partials/import')

                <div class="">
                    <button
                        wire:click="export"
                        type="button"
                        class="font-semibold text-blue-500 hover:underline"
                    >Export (JSON)</button>
                </div>

                <div class="">
                    <livewire:dashboard.pages.parts.search-and-export />
                </div>
            </div>

        </div>

        <div
            class="w-full mt-4 overflow-x-auto border"
            x-data="{
                checkAll() {
                    @this.addToSelection({ ids: Array.from(document.querySelectorAll(`[data-type='partIdCheckbox']`)).map(item => item.value) });
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
                        <th class="px-4 py-2 border-l">Active</th>
                        <th class="px-4 py-2 border-l">AddedBy</th>
                        <th class="px-4 py-2 border-l"></th>
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
                            <td class="px-4 py-2 border-l whitespace-nowrap">{{ $part->active ? 'Active' : '---' }}</td>
                            <td class="px-4 py-2 border-l whitespace-nowrap">{{ $part->addedBy->name }}</td>
                            <td class="px-4 py-2 border-l whitespace-nowrap">
                                <div class="flex items-center justify-start space-x-6">
                                    <button
                                        type="button"
                                        wire:click="edit(@js($part->id))"
                                        class="text-blue-500 hover:underline"
                                    >Edit</button>
                                    <button
                                        type="button"
                                        wire:click="deletePart(@js($part->id))"
                                        class="text-red-500 hover:underline"
                                    >Delete</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

        <div class="flex justify-end w-full mt-6">
            <div class="">{{ $parts->links() }}</div>
        </div>

    </div>


    @include('livewire.dashboard.pages.parts._partials.edit-modal')

    <div
        x-cloak
        class="fixed bottom-8 right-6"
        x-data="{
            show: false,
            type: 'success',
            message: '',
            init() {
                this.$watch('show', val => {
                    if (val) {
                        setTimeout(() => this.show = false, 4000);
                    }
                })
            },
            flash($event) {
                this.type = $event.detail.data.type;
                this.message = $event.detail.data.message;
                this.show = true;
            }
        }"
        x-on:flash-message.window="flash"
    >
        <span
            x-show="show"
            x-transition
            class="px-6 py-3 font-semibold text-white rounded-lg"
            x-bind:class="{
                'bg-emerald-400': type === 'success',
                'bg-red-500': type === 'error',
            }"
            x-text="message"
        >Message!</span>
    </div>

</div>
