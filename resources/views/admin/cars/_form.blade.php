@csrf
<div class="card-body">
  <div class="row">
    <div class="col-md-4"><x-admin.input name="brand" label="Brand" :value="$car->brand ?? null" maxlength="60" placeholder="Hyundai" /></div>
    <div class="col-md-4"><x-admin.input name="model" label="Model" :value="$car->model ?? null" maxlength="80" placeholder="Santro" /></div>
    <div class="col-md-4"><x-admin.input name="year" label="Year" type="number" min="1980" :max="now()->year + 1" :value="$car->year ?? null" /></div>

    <div class="col-md-4"><x-admin.input name="price" label="Price ($)" type="number" min="1" step="1" :value="$car->price ?? null" /></div>
    <div class="col-md-4"><x-admin.input name="old_price" label="Old price ($)" type="number" min="1" step="1" :required="false" :value="$car->old_price ?? null" hint="Optional. Must be higher than the price; shown crossed out with a discount badge." /></div>
    <div class="col-md-4"><x-admin.input name="mileage" label="Mileage (km)" type="number" min="0" step="1" :value="$car->mileage ?? 0" /></div>

    <div class="col-md-4"><x-admin.select name="fuel" label="Fuel" :options="\App\Models\Car::FUELS" :value="$car->fuel ?? 'petrol'" /></div>
    <div class="col-md-4"><x-admin.select name="transmission" label="Transmission" :options="\App\Models\Car::TRANSMISSIONS" :value="$car->transmission ?? 'manual'" /></div>
    <div class="col-md-4"><x-admin.input name="color" label="Colour" :required="false" :value="$car->color ?? null" maxlength="40" /></div>

    <div class="col-md-6"><x-admin.select name="status" label="Status" :options="\App\Models\Car::STATUSES" :value="$car->status ?? 'available'" /></div>
    <div class="col-md-6 pt-md-4 mt-md-2"><x-admin.checkbox name="is_featured" label="Featured (shown with a star badge)" :checked="$car->is_featured ?? false" /></div>
  </div>

  <x-admin.textarea name="description" label="Description" :required="false" :value="$car->description ?? null" rows="5" maxlength="3000" />

  <div class="form-group">
    <label for="image">Photo @if (empty($car))<span class="text-danger">*</span>@endif</label>
    <div class="mb-2">
      <img src="{{ ! empty($car) ? $car->image_url : '' }}" alt="Car photo" id="image-preview"
           class="img-thumbnail {{ empty($car) ? 'd-none' : '' }}" style="max-height: 180px;">
    </div>
    <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp"
           class="form-control-file @error('image') is-invalid @enderror" @required(empty($car))>
    @error('image')
      <span class="invalid-feedback d-block">{{ $message }}</span>
    @enderror
    <small class="form-text text-muted">
      Upload a JPG, PNG or WebP file up to 4 MB (landscape photos look best).@if (! empty($car)) Leave empty to keep the current photo.@endif
    </small>
  </div>
</div>
<div class="card-footer">
  <button type="submit" class="btn btn-primary">{{ $submit }}</button>
  <a href="{{ route('cars.index') }}" class="btn btn-default">Cancel</a>
</div>

@push('scripts')
<script>
  document.getElementById('image').addEventListener('change', function () {
    var file = this.files && this.files[0];
    var preview = document.getElementById('image-preview');
    if (!file) { return; }
    preview.src = URL.createObjectURL(file);
    preview.classList.remove('d-none');
  });
</script>
@endpush
