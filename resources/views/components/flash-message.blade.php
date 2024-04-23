@if (session()->has('message'))
    <x-adminlte-alert theme="info" title="{{ session('message') }}" dismissable>
    </x-adminlte-alert>
@endif
