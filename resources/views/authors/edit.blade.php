@extends ('layouts.app')
@section ('content')
    <div class="card">
        <div class="card-header">@lang('author.Title')</div>
        <div class="card-body">
            <form method="post" action="{{route('authors.update', $data['id'])}}">
                @csrf
                @method('put')
                @include('authors._form', [])
                <div class="text-right">
                    <button type="submit" class="btn btn-success btn-sm">{{__('general.Save')}}</button>
                    <a role="button" class="btn btn-secondary btn-sm" href="{{url()->previous()}}">{{__('general.Back')}}</a>
                </div>
            </form>
        </div>
    </div>
@endsection
