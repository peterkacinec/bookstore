@extends ('layouts.app')
@section ('content')
    <div class="card">
        <div class="card-header">@lang('book.New book')</div>
        <div class="card-body">
            <form method="post" action="{{route('books.store')}}">
                @csrf
                @method('post')
                @include('books._form', [])
                <div class="text-right">
                    <button type="submit" class="btn btn-success btn-sm">@lang('general.Save')</button>
                    <a role="button" class="btn btn-secondary btn-sm" href="{{url()->previous()}}">@lang('general.Back')</a>
                </div>
            </form>
        </div>
    </div>
@endsection
