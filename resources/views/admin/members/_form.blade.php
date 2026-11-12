@csrf
<div class="card-body">
  <div class="row">
    <div class="col-md-6"><x-admin.input name="name" label="Member name" :value="$member->name ?? null" maxlength="255" /></div>
    <div class="col-md-6"><x-admin.input name="role" label="Role" :value="$member->role ?? null" maxlength="255" /></div>
    <div class="col-md-6"><x-admin.input name="phone" label="Phone number" type="tel" :value="$member->phone_number ?? null" placeholder="+380 95 066 09 59" /></div>
    <div class="col-md-3"><x-admin.input name="age" label="Age" type="number" min="16" max="80" :value="$member->age ?? null" /></div>
    <div class="col-md-3"><x-admin.input name="residence" label="Place of residence" :value="$member->place_of_residence ?? null" maxlength="255" /></div>
  </div>

  <div class="form-group">
    <label for="image">Photo @if (empty($member))<span class="text-danger">*</span>@endif</label>
    @if (!empty($member))
      <div class="mb-2">
        <img src="{{ $member->image_url }}" alt="Current photo" class="img-thumbnail" style="max-height: 140px;" id="image-preview">
      </div>
    @else
      <div class="mb-2"><img src="" alt="" class="img-thumbnail d-none" style="max-height: 140px;" id="image-preview"></div>
    @endif
    <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp"
           class="form-control-file @error('image') is-invalid @enderror" @required(empty($member))>
    @error('image')
      <span class="invalid-feedback d-block">{{ $message }}</span>
    @enderror
    <small class="form-text text-muted">
      Upload a JPG, PNG or WebP file up to 2 MB.@if (!empty($member)) Leave empty to keep the current photo.@endif
    </small>
  </div>
</div>
<div class="card-footer">
  <button type="submit" class="btn btn-primary">{{ $submit }}</button>
  <a href="{{ route('members.index') }}" class="btn btn-default">Cancel</a>
</div>

@push('scripts')
<script>
  // Live preview of the selected photo
  document.getElementById('image').addEventListener('change', function () {
    var file = this.files && this.files[0];
    var preview = document.getElementById('image-preview');
    if (!file) { return; }
    preview.src = URL.createObjectURL(file);
    preview.classList.remove('d-none');
  });
</script>
@endpush
