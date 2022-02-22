@if (Session::has('success'))
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        <strong>Notification:</strong> {{ Session::get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (isset($errors) && !$errors->isEmpty())
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        <strong>Error:</strong> fix the errors to be able to continue
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <ul>
            @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif