@props(['name', 'label', 'options', 'value' => null, 'required' => true])

<div class="form-group">
  <label for="{{ $name }}">{{ $label }} @if ($required)<span class="text-danger">*</span>@endif</label>
  <select
    id="{{ $name }}"
    name="{{ $name }}"
    @required($required)
    {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}
  >
    @foreach ($options as $key => $text)
      <option value="{{ $key }}" @selected((string) old($name, $value) === (string) $key)>{{ $text }}</option>
    @endforeach
  </select>
  @error($name)
    <span class="invalid-feedback d-block">{{ $message }}</span>
  @enderror
</div>
