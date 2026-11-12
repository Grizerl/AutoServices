@extends('layouts.admin_layouts')
@section('title', 'Subscriptions')
@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Subscriptions</h3>
        <div class="card-tools">
          <form method="get">
            <select name="status" class="form-control form-control-sm" onchange="this.form.submit()" aria-label="Filter by status">
              <option value="">All statuses</option>
              @foreach (\App\Models\Subscription::STATUSES as $key => $label)
                <option value="{{ $key }}" @selected($status === $key)>{{ $label }}</option>
              @endforeach
            </select>
          </form>
        </div>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Reference</th>
              <th>Customer</th>
              <th class="d-none d-md-table-cell">Plan</th>
              <th class="d-none d-lg-table-cell">Car</th>
              <th>Status</th>
              <th class="d-none d-lg-table-cell">Term</th>
              <th style="width: 1%"></th>
            </tr>
          </thead>
          <tbody>
            @php($badges = ['pending' => 'warning', 'active' => 'success', 'cancelled' => 'secondary', 'expired' => 'dark'])
            @forelse ($subscriptions as $subscription)
              <tr>
                <td class="text-nowrap"><a href="{{ route('subscriptions.show', $subscription) }}"><strong>{{ $subscription->reference }}</strong></a>
                  <div class="text-muted small">{{ $subscription->created_at?->format('Y-m-d') }}</div></td>
                <td>
                  {{ $subscription->name }}
                  <div class="small"><a href="tel:{{ preg_replace('/[^\d+]/', '', $subscription->phone) }}">{{ $subscription->phone }}</a></div>
                </td>
                <td class="d-none d-md-table-cell">
                  {{ $subscription->plan_name }}
                  <div class="text-muted small">${{ number_format($subscription->price) }} / {{ $subscription->billing_period === 'yearly' ? 'year' : 'month' }}</div>
                </td>
                <td class="d-none d-lg-table-cell">{{ $subscription->car }}</td>
                <td><span class="badge badge-{{ $badges[$subscription->status] ?? 'secondary' }}">{{ $subscription->status_label }}</span></td>
                <td class="d-none d-lg-table-cell text-nowrap">
                  @if ($subscription->starts_at)
                    {{ $subscription->starts_at->format('Y-m-d') }} → {{ $subscription->ends_at?->format('Y-m-d') }}
                  @else
                    <span class="text-muted">&mdash;</span>
                  @endif
                </td>
                <td class="text-nowrap">
                  <a class="btn btn-primary btn-sm" title="Open" href="{{ route('subscriptions.show', $subscription) }}"><i class="fas fa-folder"></i><span class="d-none d-lg-inline"> Open</span></a>
                  <form action="{{ route('subscriptions.destroy', $subscription) }}" method="post" class="d-inline" data-confirm="Delete subscription {{ $subscription->reference }}?">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" title="Delete" type="submit"><i class="fas fa-trash"></i></button>
                  </form>
                </td>
              </tr>
            @empty
              <tr><td colspan="7" class="text-center text-muted py-4">No subscriptions yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @if ($subscriptions->hasPages())
        <div class="card-footer">{{ $subscriptions->links() }}</div>
      @endif
    </div>
  </div>
</section>
@endsection
