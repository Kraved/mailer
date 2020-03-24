@if (session()->has('success'))
    <div class="alert alert-success text-center" role="alert">
        <strong> {{session('success')}} </strong>
    </div>
@endif
