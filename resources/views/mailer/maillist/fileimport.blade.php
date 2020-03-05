
@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body d-flex justify-content-center text-center">
            <form class="form-group"  method="post" action="{{ route('mailer.maillist.savefromimportfile') }}" enctype="multipart/form-data">
                @csrf
                <label for="file"><h3>Загрузить файл</h3></label>
                <input type="file" class="form-control-file mb-3" name="importfile" id="importfile" aria-describedby="fileHelpId">
                <button type="submit" class="btn btn-primary">Импорт</button>
                <small id="fileHelpId" class="form-text text-muted">
                    Файл должен быть в формате .txt <br>
                    Должен содержать список почтовых адресов по 1 на строке
                </small>
            </form>
        </div>
    </div>
@stop
