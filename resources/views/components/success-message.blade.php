@if (isset($success) || session('success'))
<div {{ $attributes }}>
    <div class="font-medium text-green-600">
        {{ __('Success!') }}
    </div>
    <ul class="mt-3 list-disc list-inside text-sm text-green-600">
        {{ $success ?? session('success') }}
    </ul>
</div>
@endif