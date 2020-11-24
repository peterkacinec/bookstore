@extends ('layouts.app')
@section ('content')
    <div class="card">
        <div class="card-header">@lang('book.Title')</div>
        <div class="card-body">
            <form method="post" action="{{route('books.update', $data['id'])}}">
                @csrf
                @method('put')
                @include('books._form', [])
                <div class="text-right">
                    <button type="submit" class="btn btn-success btn-sm">@lang('general.Save')</button>
                    <a role="button" class="btn btn-secondary btn-sm" href="{{url()->previous()}}">@lang('general.Back')</a>
                </div>
            </form>
        </div>
    </div>
@endsection
