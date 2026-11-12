@csrf
<div class="card-body">
  <x-admin.input name="title" label="Title" :value="$post->title ?? null" maxlength="255" />
  <x-admin.textarea name="content_post" label="Content" :value="$post->content ?? null" rows="6" maxlength="5000" />
</div>
<div class="card-footer">
  <button type="submit" class="btn btn-primary">{{ $submit }}</button>
  <a href="{{ route('post.index') }}" class="btn btn-default">Cancel</a>
</div>
