{{-- @if (session()->has('message')) --}}
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-ban"></i>{{ $errors->first() }}</h5>
    </div>
@endif
