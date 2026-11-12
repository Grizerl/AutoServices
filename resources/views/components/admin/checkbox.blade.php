@props(['name', 'label', 'checked' => false, 'hint' => null])

<div class="form-group">
  <div class="custom-control custom-checkbox">
    <input type="hidden" name="{{ $name }}" value="0">
    <input
      type="checkbox"
      class="custom-control-input"
      id="{{ $name }}"
      name="{{ $name }}"
      value="1"
      @checked(old($name, $checked))
    >
    <label class="custom-control-label" for="{{ $name }}">{{ $label }}</label>
  </div>
  @if ($hint)
    <small class="form-text text-muted">{{ $hint }}</small>
  @endif
  @error($name)
    <span class="invalid-feedback d-block">{{ $message }}</span>
  @enderror
</div>
