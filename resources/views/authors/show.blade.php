@extends ('layouts.app')
@section ('content')
    @php
        $actionDelete =[
            'url' => url('/'.\App\Models\Author::ENTITY_ROUTE_PREFIX.'/'.$data['id']),
            'text' => __('general.Confirmation delete'),
            'requestMethod' => 'DELETE',
        ];
    @endphp
    <div class="form-group">
        <a role="button" class="btn btn-primary btn-sm" href="{{ route('authors.edit', $data['id']) }}">@lang('general.Edit')</a>
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
                <label for="name" class="col-sm-3 col-form-label">@lang('author.Name')</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="name" id="name" value="{{ $data['name'] }}" disabled/>
                </div>
            </div>
            <div class="form-group row">
                <label for="surname" class="col-sm-3 col-form-label">@lang('author.Surname')</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="surname" id="surname" value="{{ $data['surname'] }}" disabled/>
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
