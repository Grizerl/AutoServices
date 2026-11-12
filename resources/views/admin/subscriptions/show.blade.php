@extends('layouts.admin_layouts')
@section('title', 'Subscription '.$subscription->reference)
@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-6">
        <div class="card card-primary">
          <div class="card-header"><h3 class="card-title">Subscription {{ $subscription->reference }}</h3></div>
          <div class="card-body">
            <dl class="row mb-0">
              <dt class="col-sm-4">Plan</dt>
              <dd class="col-sm-8">
                {{ $subscription->plan_name }}
                @if ($subscription->plan)
                  <a href="{{ route('plans.edit', $subscription->plan) }}" class="small ml-1">(edit plan)</a>
                @else
                  <span class="text-muted small">(plan deleted)</span>
                @endif
              </dd>
              <dt class="col-sm-4">Billing</dt>
              <dd class="col-sm-8">{{ $subscription->period_label }} · ${{ number_format($subscription->price) }} / {{ $subscription->billing_period === 'yearly' ? 'year' : 'month' }}</dd>
              <dt class="col-sm-4">Customer</dt>
              <dd class="col-sm-8">{{ $subscription->name }}</dd>
              <dt class="col-sm-4">Phone</dt>
              <dd class="col-sm-8"><a href="tel:{{ preg_replace('/[^\d+]/', '', $subscription->phone) }}">{{ $subscription->phone }}</a></dd>
              <dt class="col-sm-4">E-mail</dt>
              <dd class="col-sm-8">@if ($subscription->email)<a href="mailto:{{ $subscription->email }}">{{ $subscription->email }}</a>@else<span class="text-muted">&mdash;</span>@endif</dd>
              <dt class="col-sm-4">Car</dt>
              <dd class="col-sm-8">{{ $subscription->car }}</dd>
              <dt class="col-sm-4">Notes</dt>
              <dd class="col-sm-8">{{ $subscription->notes ?: '—' }}</dd>
              <dt class="col-sm-4">Requested</dt>
              <dd class="col-sm-8">{{ $subscription->created_at?->format('Y-m-d H:i') }}</dd>
            </dl>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="card">
          <div class="card-header"><h3 class="card-title">Status and term</h3></div>
          <form action="{{ route('subscriptions.update', $subscription) }}" method="post">
            @csrf @method('PUT')
            <div class="card-body">
              <x-admin.select name="status" label="Status" :options="\App\Models\Subscription::STATUSES" :value="$subscription->status" />
              <div class="row">
                <div class="col-sm-6"><x-admin.input name="starts_at" label="Start date" type="date" :required="false" :value="$subscription->starts_at?->format('Y-m-d')" /></div>
                <div class="col-sm-6"><x-admin.input name="ends_at" label="End date" type="date" :required="false" :value="$subscription->ends_at?->format('Y-m-d')" /></div>
              </div>
              <p class="text-muted small mb-0">
                Setting the status to <strong>Active</strong> fills in the term automatically
                (starts today, ends after one {{ $subscription->billing_period === 'yearly' ? 'year' : 'month' }}) unless you enter dates.
              </p>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Save</button>
              <a href="{{ route('subscriptions.index') }}" class="btn btn-default">Back to list</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
