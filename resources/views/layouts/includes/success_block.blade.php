@if (session()->has('msg'))
    <div class="alert alert-success" role="alert">
        <strong> {{session('msg')}} </strong>
    </div>
@endif
