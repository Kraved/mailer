@if (session()->has('success'))
    @foreach (session('success') as $line)
        <div class="alert alert-success text-center" role="alert">
            <strong> {{ $line }} </strong>
        </div>
    @endforeach
@endif
