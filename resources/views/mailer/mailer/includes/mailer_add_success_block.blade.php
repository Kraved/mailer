@if (session()->has('result'))
    @foreach (session('result') as $line)
        <div class="alert alert-success text-center" role="alert">
            <strong> {{ $line }} </strong>
        </div>
    @endforeach
@endif
