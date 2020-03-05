<form class="align-self-end" action="{{ route('mailer.maillist.deleteall') }}" method="post">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Удалить все</button>
</form>
