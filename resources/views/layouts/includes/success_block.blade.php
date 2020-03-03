@if (session()->has('msg'))
    <div class="alert alert-success text-center" role="alert">
        <strong> {{session('msg')}} </strong>
    </div>
@endif
