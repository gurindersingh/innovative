<div
    class=""
    x-data="{
        importing: false,
        importFile($event) {
            if ($event.target.files[0].type !== 'application/json') return;

            this.importing = true;

            let reader = new FileReader();
            reader.onload = (e) => {
                @this.import({ content: JSON.parse(e.target.result) }).then(res => {
                    this.importing = false;
                });
            };
            reader.readAsText($event.target.files[0]);
        }
    }"
>
    <input
        type="file"
        accept="application/json"
        x-on:change="importFile"
        x-ref="fileInput"
        style="display: none"
    />
    <button
        x-on:click="
            $refs.fileInput.value = null;
            $refs.fileInput.click()
        "
        type="button"
        class="font-semibold text-blue-500 hover:underline"
    >Import</button>
</div>
