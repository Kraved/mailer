@extends('layouts.app')

@section('content')
    <div class="text-right mb-3 mr-5">
        <a class="btn btn-primary" href="{{ route('mailer.maillist.create') }}" role="button">Добавить</a>
        <a class="btn btn-primary" href="{{ route('mailer.maillist.importfromfile') }}" role="button">Экспорт из файла</a>
        <a class="btn btn-primary" href="{{ route('mailer.maillist.importfromsite') }}" role="button">Экспорт с сайта</a>
    </div>

    <table class="table table-striped text-center">
        <thead>
        <tr>
            <th class="col-3" scope="col">#</th>
            <th class="col-3" scope="col">Email</th>
            <th class="col-3" scope="col">Добавлено</th>
            <th class="col-3" scope="col">Удалить</th>
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
        <div class=" card-body d-flex justify-content-between">
            @if ($emails->total() > $emails->count())
                {{ $emails->links() }}
            @endif
            @include('mailer.maillist.includes.index_delete_all_form')
        </div>
    </div>
@stop
