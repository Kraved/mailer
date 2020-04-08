@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-3">
            <a class="btn btn-primary mr-auto export_block" href="{{ route('mailer.maillist.export') }}" role="button">Экспорт</a>
            <div class="col-3 d-flex justify-content-around import_block">
                <a class="btn btn-primary" href="{{ route('mailer.maillist.create') }}"
                   role="button">Добавить</a>
                <a class="btn btn-primary" href="{{ route('mailer.maillist.import.site') }}"
                   role="button">Импорт с сайта</a>
                <a class="btn btn-primary" href="{{ route('mailer.maillist.import.file') }}"
                   role="button">Импорт из файла</a>
            </div>
        </div>
    </div>


    <table class="table table-striped text-center">
        <thead>
        <tr>
            <th>#</th>
            <th>Email</th>
            <th>Добавлено</th>
            <th>Удалить</th>
        </tr>
        </thead>
        <tbody>
        @php $i = 1; @endphp
        @foreach ($emails as $item)
            <tr>
                <th scope="row">{{ $i++ }}</th>
                <td><a href="{{ route('mailer.maillist.edit', $item->id) }}">{{ $item->email }}</a></td>
                <td>{{ $item->created_at }}</td>
                <td>@include('mailer.maillist.includes.index_delete_form')</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="card">
        <div class="card-body">
            @if ($emails->total() > $emails->count())
                {{ $emails->links() }}
            @endif
            @include('mailer.maillist.includes.index_delete_all_form')
        </div>
    </div>
@stop
