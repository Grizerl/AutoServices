@props(['name', 'label', 'value' => null, 'required' => true, 'rows' => 5])

<div class="form-group">
  <label for="{{ $name }}">{{ $label }} @if ($required)<span class="text-danger">*</span>@endif</label>
  <textarea
    id="{{ $name }}"
    name="{{ $name }}"
    rows="{{ $rows }}"
    @required($required)
    {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}
  >{{ old($name, $value) }}</textarea>
  @error($name)
    <span class="invalid-feedback d-block">{{ $message }}</span>
  @enderror
</div>
