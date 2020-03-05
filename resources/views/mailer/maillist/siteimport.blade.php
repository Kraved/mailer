@extends('layouts.app')

@section('content')
    <div class="card">
      <div class="card-body">
          <form class="d-flex justify-content-center text-center" action="{{ route('mailer.maillist.savefromimportsite') }}" method="post" role="form">
              @csrf
              <div class="form-group col-4">
                  <label for="site"><h2>Введите сайт</h2></label>
                  <input type="text" class="form-control mb-3" size="300" name="site">
                  <button type="submit" class="btn btn-primary">Submit</button>
              </div>
          </form>
      </div>
    </div>
@stop
