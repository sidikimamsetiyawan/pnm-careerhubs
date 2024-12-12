@if (!@empty(session('success')))
    <div class="alert alert-success" role="alert">
        {{ sesion('success') }}
    </div>
@endif
    
@if (!@empty(session('error')))
    <div class="alert alert-danger" role="alert">
        {{ sesion('error') }}
    </div>
@endif