@csrf
<div class="card-body">
  <x-admin.input name="name" label="Customer name" :value="$client->name ?? null" maxlength="255" />
  <x-admin.input name="role" label="Role / car" :value="$client->role ?? null" maxlength="255" hint="Shown under the name, e.g. “Owner of Toyota Camry”." />
  <x-admin.textarea name="commentars" label="Comment" :value="$client->commentars ?? null" rows="4" maxlength="1000" />
</div>
<div class="card-footer">
  <button type="submit" class="btn btn-primary">{{ $submit }}</button>
  <a href="{{ route('client.index') }}" class="btn btn-default">Cancel</a>
</div>
