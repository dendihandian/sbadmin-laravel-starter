{{-- TODO: not the same as image.blade.php --}}

<div class="form-group col-lg-{{ $_col ?? 6 }}">
    <label for="{{ $_name }}">{{ $_title ?? '' }}</label>

    @if ($_readonly ?? false)
        <img src="{{ $_file_link }}" alt="{{ $_value }}">
    @else
        <input type="hidden" name="{{ $_name }}-value" value="{{ $_value ?? null }}">
        <input class="form-control-file @error($_name) is-invalid @enderror" type="file" name="{{ $_name }}" id="{{ $_name }}" value="{{ $_value ?? null }}">
        @error($_name)
            <span class="invalid-feedback" user="alert"><strong>{{ $message }}</strong></span>
        @else
            @if ($_name ?? false)
                <small id="{{$_name}}_help" class="form-text text-muted">{{ $_desc ?? '' }}</small>
            @endif
        @enderror
    @endif

</div>