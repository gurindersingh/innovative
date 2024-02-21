<div class="flex flex-col items-center justify-start w-full min-h-screen px-6">

    <div class="w-full max-w-screen-sm mt-20 lg:mt-40">
        <div class="flex flex-col items-center pb-6 space-y-1 border-b">
            <p class="text-xl font-semibold text-slate-700">Welcome to</p>
            <h1 class="font-bold text-blue-500 text-7xl">{{ config('app.name') }}</h1>
        </div>

        <div class="flex flex-col items-center w-full mt-6">
            <p class="mb-4 text-xl font-semibold text-slate-700">Login to get started</p>
            <a
                href="{{ route('login') }}"
                class="px-20 py-3 font-semibold text-white transition bg-blue-500 rounded-lg hover:bg-blue-600"
            >Login</a>
        </div>
    </div>

</div>
