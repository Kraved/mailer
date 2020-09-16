@extends('layouts.app')

@section('content')
<ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
           aria-controls="pills-home" aria-selected="true">Файл</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
           aria-controls="pills-profile" aria-selected="false">Сайт</a>
    </li>
</ul>

<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
        <div class="card">
            <div class="card-body d-flex justify-content-center text-center">
                <form class="form-group"  method="post" action="{{ route('mailer.maillist.import.save') }}" enctype="multipart/form-data">
                    @csrf
                    <h3><label for="file">Загрузить файл</label></h3>
                    <input type="file" class="form-control-file mb-3" name="importfile" id="importfile" aria-describedby="fileHelpId">
                    <button type="submit" class="btn btn-primary">Импорт</button>
                    <small id="fileHelpId" class="form-text text-muted">
                        Файл должен быть в формате .txt <br>
                        Должен содержать список почтовых адресов по 1 на строке
                    </small>
                </form>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
        <div class="card">
            <div class="card-body">
                <form class="d-flex justify-content-center text-center" action="{{ route('mailer.maillist.import.save') }}" method="post" role="form">
                    @csrf
                    <div class="form-group col-4">
                        <h3><label for="site">Введите сайт</label></h3>
                        <input type="text" class="form-control mb-3" size="300" name="site">
                        <button type="submit" class="btn btn-primary">Импорт</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


