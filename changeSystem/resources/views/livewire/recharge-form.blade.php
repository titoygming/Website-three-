<div x-data="form()"
    class="bg-zinc-800 rounded-md w-full md:max-w-lg p-6 space-y-4 border border-zinc-700 md:mx-auto">

    <h1 class="text-center text-xl font-bold text-slate-100">RECHARGE</h1>

    <div class="flex bg-zinc-700 rounded-xl overflow-hidden">
        <button @click="tab='moncash'" :class="tab === 'moncash' ? 'bg-blue-600 text-white' : 'text-zinc-400'"
            class="flex-1 py-2 text-sm font-medium">Moncash</button>
        <button @click="tab='natcash'" :class="tab === 'natcash' ? 'bg-blue-600 text-white' : 'text-zinc-400'"
            class="flex-1 py-2 text-sm font-medium">Natcash</button>
    </div>

    <div class="text-sm text-zinc-300 space-y-3">
        <div class="flex-1">
            <div class="flex items-center justify-between">
                <p>
                    <strong>Number:</strong> 43053547
                </p>
                <x-ts-clipboard icon text="43053547" />

            </div>
        </div>
        <div class="flex justify-between items-center">
            <p><strong>Name:</strong> Love Jean Martineau DORVIL</p>
            <a href="#" class="text-primary-500 text-xs hover:underline">Guide</a>
        </div>
    </div>

    <div>
        <x-ts-input x-model="formData.name" label="Fullname *" placeholder="" />
    </div>

    <div>
        <x-ts-input x-model="formData.transactionId" label="Transaction ID ou Transcode *" placeholder="1234567890" />
    </div>

    <div>
        <x-ts-input x-model="formData.amount" icon="currency-dollar" label="Amount *" placeholder="100"
            type="number" />
    </div>

    <div>
        <x-ts-input x-model="formData.phone" prefix="+509" icon="phone" position="right"
            label="Sender Phone number *" placeholder="43053547" />
    </div>


    <div>
        <x-ts-upload class="mx-auto h-48" wire:model="screenshot" label="Transaction screenshot" hint="We need the transaction screenshot to analyze your submission" tip="Drag and drop your screenshot here"/>
    </div>


    <button class="w-full bg-primary-500 text-white py-2 rounded-lg hover:bg-blue-700 transition">
        Submit
    </button>

    <script>
        function form() {
            return {
                tab: 'natcash',
                formData: {
                    name: '',
                    transactionId: '',
                    amount: '',
                    phone: '',
                    file: null
                },
                handleFile(e) {
                    this.formData.file = e.target.files[0];
                },
                submit() {
                    console.log(this.formData);
                    alert('Form submitted');
                }
            }
        }
    </script>
</div>
