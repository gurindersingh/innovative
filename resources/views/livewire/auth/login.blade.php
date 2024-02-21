<div class="w-full max-w-screen-sm pt-20 md:pt-40">

    <div class="flex items-center justify-between pb-6 space-y-1">
        <h1 class="text-3xl font-bold text-blue-500">{{ config('app.name') }}</h1>
        <p class="text-xl font-semibold text-slate-700">Login</p>
    </div>

    <div class="p-6 border rounded-lg shadow-sm bg-slate-50">
        <div
            class="flex flex-col items-center w-full mt-6"
            x-data="{
                showPassword: false,
            }"
        >
            <form
                action="#"
                wire:submit="login"
                class="w-full space-y-4"
            >

                <div class="flex flex-col w-full">
                    <x-form.label>Email</x-form.label>
                    <x-form.input
                        type="email"
                        wire:model="email"
                        required
                        name="email"
                    />
                    <x-form.error :error="$errors->first('email')" />
                </div>

                <div class="flex flex-col">
                    <div class="flex items-center justify-between">
                        <x-form.label>Password</x-form.label>
                        <button
                            type="button"
                            x-on:click="showPassword = !showPassword"
                        >
                            <span
                                class=""
                                x-show="!showPassword"
                            >
                                <x-heroicon-o-eye class="w-4 h-4 text-slate-700" />
                            </span>
                            <span
                                class=""
                                x-show="showPassword"
                            >
                                <x-heroicon-o-eye-slash class="w-4 h-4 text-slate-700" />
                            </span>
                        </button>
                    </div>
                    <x-form.input
                        type="password"
                        wire:model="password"
                        required
                        name="password"
                        x-bind:type="showPassword ? 'text' : 'password'"
                    />
                    <x-form.error :error="$errors->first('password')" />
                </div>


                <div class="flex justify-end pt-2 mt-6">
                    <x-form.button
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:loading.class="animate-pulse"
                    >Login</x-form.button>
                </div>
            </form>
        </div>
    </div>

</div>
