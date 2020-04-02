@extends('layouts.app')

@section('content')
    @include('mailer.mailer.includes.mailer_add_success_block')
    <form class="d-flex justify-content-center" action="{{ route('mailer.mailer.send') }}" method="post" role="form"
          enctype="multipart/form-data">
        @csrf
        <div class="form-group col-4 text-center">
            <label for="subject">Введите тему письма: </label>
            <input type="text" class="form-control" name="subject" id="subject">
            <label for="text">Введите сообщение: </label>
            <textarea rows="5" class="form-control mb-3" name="text" id="text">
            </textarea>
            <label for="file">Прикрепите файл(необязательно)</label>
            <input type="file" class="form-control-file" name="file" id="file">
            <button type="submit" class="btn btn-primary">Отправить</button>
        </div>
    </form>
@stop
