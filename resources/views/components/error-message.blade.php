@if (session('error'))
<div {{ $attributes }}>
    <div class="font-medium text-red-600">
        {{ __('Error!') }}
    </div>

    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
        {{ session('error') }}
    </ul>
</div>
@endif