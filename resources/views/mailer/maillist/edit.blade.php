@extends('layouts.app')

@section('content')
    <div class="card d-flex w-100 align-items-center" style="width: 20rem;">
        <div class="col-3 card-body text-center">
            <h4 class="card-title">Изменить почту</h4>
            <form action="{{ route('mailer.maillist.update', $item->id) }}" method="post">
                @csrf
                @method('PATCH')
                <label for=""></label>
                <input type="text" class="form-control mb-3" name="email" placeholder="{{ $item->email }}">
                <button type="submit" class="btn btn-primary">Редактировать</button>
            </form>
        </div>
    </div>
@stop


