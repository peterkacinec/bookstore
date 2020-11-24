<div class="form-group row">
    <label for="name" class="col-sm-3 col-form-label">@lang('author.Name')</label>
    <div class="col-sm-9">
        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $data->name ?? null) }}"/>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label for="surname" class="col-sm-3 col-form-label">@lang('author.Surname')</label>
    <div class="col-sm-9">
        <input class="form-control {{ $errors->has('surname') ? 'is-invalid' : '' }}" type="text" name="surname" id="surname" value="{{ old('surname', $data->surname ?? null) }}"/>
        @error('surname')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
