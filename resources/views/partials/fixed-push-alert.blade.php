<div class="push-alert">
    
    @if (session('push-success'))
        <div class="alert alert-success" x-data="{ show : true }"
            x-init="setTimeout(() => show = false, 6000)"
            x-show="show">
            {{ session('push-success') }}
        </div>
    @endif

    @if (session('push-error'))
        <div class="alert alert-danger" x-data="{ show : true }"
            x-init="setTimeout(() => show = false, 6000)"
            x-show="show">
            {{ session('push-error') }}
        </div>
    @endif

    @if (session('push-warning'))
        <div class="alert alert-warning" x-data="{ show : true }"
            x-init="setTimeout(() => show = false, 6000)"
            x-show="show">
            {{ session('push-warning') }}
        </div>
    @endif

    @if (session('push-info'))
        <div class="alert alert-info" x-data="{ show : true }"
            x-init="setTimeout(() => show = false, 6000)"
            x-show="show">
            {{ session('push-info') }}
        </div>
    @endif

</div>