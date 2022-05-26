<div style="text-align: center">
    <div class="mb-2">
        <button class="btn btn-sm btn-success" onClick="start()">Start Counter</button>
    </div>
    <h1>{{ $count }}</h1>
    <div class="mb-2">
        <button class="btn btn-sm btn-primary" wire:click="decrement">Decrement Counter</button>
    </div>
    <div>
        <button class="btn btn-sm btn-danger" onClick="clearTimer()">Stop Counter</button>
        <button class="btn btn-sm btn-info" onClick="@this.clear(0)">Reset Counter</button>
    </div>
    @push('scripts')
    <script>
        let status = false
        let timer = null
        document.addEventListener('livewire:load', function () {
            @this.on('eventName', () => {
                console.log('send req to trigger functionName on server')
                timer = setTimeout(@this.increment, 1000)
            })
        })

        function start() {
            if (status)
                return
            status = true
            @this.increment()
        }

        function clearTimer() {
            status = false
            if (timer) {
                clearTimeout(timer)
                timer = null
            }
        }
    </script>
    @endpush
    @stack('scripts')
</div>
