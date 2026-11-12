@props(['name', 'label', 'type' => 'text', 'value' => null, 'required' => true, 'hint' => null])

<div class="form-group">
  <label for="{{ $name }}">{{ $label }} @if ($required)<span class="text-danger">*</span>@endif</label>
  <input
    id="{{ $name }}"
    name="{{ $name }}"
    type="{{ $type }}"
    value="{{ $type === 'file' ? '' : old($name, $value) }}"
    @required($required)
    {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}
  >
  @error($name)
    <span class="invalid-feedback d-block">{{ $message }}</span>
  @enderror
  @if ($hint)
    <small class="form-text text-muted">{{ $hint }}</small>
  @endif
</div>
