@if (session('success'))
    <div class="alert alert-success" x-data="{ show : true }"
        x-init="setTimeout(() => show = false, 5000)"
        x-show="show">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger" x-data="{ show : true }"
        x-init="setTimeout(() => show = false, 5000)"
        x-show="show">
        {{ session('error') }}
    </div>
@endif

@if (session('warning'))
    <div class="alert alert-warning" x-data="{ show : true }"
        x-init="setTimeout(() => show = false, 5000)"
        x-show="show">
        {{ session('warning') }}
    </div>
@endif

@if (session('info'))
    <div class="alert alert-info" x-data="{ show : true }"
        x-init="setTimeout(() => show = false, 5000)"
        x-show="show">
        {{ session('info') }}
    </div>
@endif