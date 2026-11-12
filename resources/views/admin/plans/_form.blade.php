@csrf
<div class="card-body">
  <div class="row">
    <div class="col-md-6"><x-admin.input name="name" label="Plan name" :value="$plan->name ?? null" maxlength="60" placeholder="Standard" /></div>
    <div class="col-md-6"><x-admin.input name="slug" label="URL slug" :value="$plan->slug ?? null" maxlength="80" placeholder="standard" hint="Lowercase letters, numbers and dashes. Used in the checkout link." /></div>
    <div class="col-12"><x-admin.input name="description" label="Short description" :required="false" :value="$plan->description ?? null" maxlength="255" /></div>

    <div class="col-md-4"><x-admin.input name="price_monthly" label="Monthly price ($)" type="number" min="1" step="1" :value="$plan->price_monthly ?? null" /></div>
    <div class="col-md-4"><x-admin.input name="price_yearly" label="Yearly price ($)" type="number" min="1" step="1" :required="false" :value="$plan->price_yearly ?? null" hint="Optional. Leave empty to charge 12 × the monthly price." /></div>
    <div class="col-md-4"><x-admin.select name="icon" label="Icon" :options="\App\Models\SubscriptionPlan::ICONS" :value="$plan->icon ?? 'fa-star'" /></div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <x-admin.textarea name="features" label="Included features" :value="$plan->features ?? null" rows="7" maxlength="2000" />
      <small class="form-text text-muted" style="margin-top: -10px; margin-bottom: 12px;">One feature per line. Shown with a green check.</small>
    </div>
    <div class="col-md-6">
      <x-admin.textarea name="excluded_features" label="Not included" :required="false" :value="$plan->excluded_features ?? null" rows="7" maxlength="2000" />
      <small class="form-text text-muted" style="margin-top: -10px; margin-bottom: 12px;">One item per line. Shown crossed out, so customers can compare plans.</small>
    </div>
  </div>

  <div class="row">
    <div class="col-md-4"><x-admin.input name="sort_order" label="Sort order" type="number" min="0" :required="false" :value="$plan->sort_order ?? 0" hint="Lower numbers are shown first." /></div>
    <div class="col-md-4 pt-md-4"><x-admin.checkbox name="is_popular" label="Mark as “Most popular”" :checked="$plan->is_popular ?? false" /></div>
    <div class="col-md-4 pt-md-4"><x-admin.checkbox name="is_active" label="Visible on the website" :checked="$plan->is_active ?? true" /></div>
  </div>
</div>
<div class="card-footer">
  <button type="submit" class="btn btn-primary">{{ $submit }}</button>
  <a href="{{ route('plans.index') }}" class="btn btn-default">Cancel</a>
</div>
