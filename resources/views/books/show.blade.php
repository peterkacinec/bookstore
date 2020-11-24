@extends ('layouts.app')
@section ('content')
    @php
        $actionDelete =[
            'url' => url('/'.\App\Models\Book::ENTITY_ROUTE_PREFIX.'/'.$data['id']),
            'text' => __('general.Confirmation delete'),
            'requestMethod' => 'DELETE',
        ];
    @endphp
    <div class="form-group">
        <a role="button" class="btn btn-primary btn-sm" href="{{ route('books.edit', $data['id']) }}">@lang('general.Edit')</a>
        <a
            role="button"
            href="#"
            class = "btn btn-sm btn-danger"
            data-toggle="modal"
            data-target="#modalConfirm"
        >@lang('general.Delete')</a>
        <modal-component
            :config="{{ json_encode($actionDelete) }}">
        </modal-component>
    </div>
    <div class="card">
        <div class="card-header">@lang('author.Title')</div>
        <div class="card-body">
            <div class="form-group row">
                <label for="title" class="col-sm-3 col-form-label">@lang('book.Book title')</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="title" id="title" value="{{ $data['title'] }}" disabled/>
                </div>
            </div>
            <div class="form-group row">
                <label for="author" class="col-sm-3 col-form-label">@lang('book.Author')</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="author" id="author" value="{{ $data['author_full_name'] }}" disabled/>
                </div>
            </div>
            <div class="form-group row">
                <label for="is_borrowed" class="col-sm-3 col-form-label">@lang('book.Is borrowed')</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="is_borrowed" id="is_borrowed" value="{{ $data['is_borrowed_label'] }}" disabled/>
                </div>
            </div>
            <div class="form-group row">
                <label for="created_at" class="col-sm-3 col-form-label">@lang('general.Created at')</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="created_at" value="{{ $data['created_at'] }}" disabled/>
                </div>
            </div>
            <div class="form-group row">
                <label for="updated_at" class="col-sm-3 col-form-label">@lang('general.Updated at')</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="updated_at" value="{{ $data['updated_at'] }}" disabled/>
                </div>
            </div>
        </div>
    </div>
@endsection
