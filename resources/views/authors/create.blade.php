@extends ('layouts.app')
@section ('content')
    <div class="card">
        <div class="card-header">@lang('author.New author')</div>
        <div class="card-body">
            <form method="post" action="{{route('authors.store')}}">
                @csrf
                @method('post')
                @include('authors._form', [])
                <div class="text-right">
                    <button type="submit" class="btn btn-success btn-sm">{{__('general.Save')}}</button>
                    <a role="button" class="btn btn-secondary btn-sm" href="{{url()->previous()}}">{{__('general.Back')}}</a>
                </div>
            </form>
        </div>
    </div>
@endsection
