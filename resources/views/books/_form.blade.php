<div class="form-group row">
    <label for="title" class="col-sm-3 col-form-label">@lang('book.Book title')</label>
    <div class="col-sm-9">
        <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $data['title'] ?? null) }}"/>
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label for="author_id" class="col-sm-3 col-form-label">@lang('book.Author')</label>
    <div class="col-sm-9">
        <select class="form-control {{ $errors->has('author_id') ? 'is-invalid' : '' }}" name="author_id" id="author_id">
            <option value="">@lang('general.Choose')</option>
            @foreach($authors as $author)
                <option value="{{ $author['id'] }}"
                    @if(old('author_id') == $author['id'])selected="selected"
                    @elseif(isset($data['author_id']) && $data['author_id'] == $author['id'])selected="selected"
                    @endif
                >
                    {{ $author['full_name'] }}
                </option>
            @endforeach
        </select>
        @foreach ($errors->get('author_id') as $message)
            <div class="invalid-feedback">{{ $message }}</div>
        @endforeach
    </div>
</div>
<div class="form-group row">
    <label for="is_borrowed" class="col-sm-3 col-form-label">@lang('book.Is borrowed')</label>
    <div class="col-sm-9">
        <input class="form-control {{ $errors->has('is_borrowed') ? 'is-invalid' : '' }}" type="checkbox" name="is_borrowed" id="is_borrowed" value="{{ old('is_borrowed', 1) }}" @if(old('is_borrowed', $data['is_borrowed'] ?? null) == 1) checked @endif/>
        @error('is_borrowed')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
