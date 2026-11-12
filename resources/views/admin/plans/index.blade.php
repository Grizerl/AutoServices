@extends('layouts.admin_layouts')
@section('title', 'Subscription plans')
@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Subscription plans</h3>
        <div class="card-tools">
          <a href="{{ route('plans.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add plan</a>
        </div>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-striped">
          <thead>
            <tr>
              <th style="width: 1%">Order</th>
              <th>Plan</th>
              <th>Monthly</th>
              <th class="d-none d-md-table-cell">Yearly</th>
              <th>Visibility</th>
              <th class="d-none d-lg-table-cell">Subscriptions</th>
              <th style="width: 1%"></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($plans as $plan)
              <tr>
                <td>{{ $plan->sort_order }}</td>
                <td>
                  <i class="fa-solid {{ $plan->icon }} text-danger mr-1"></i> <strong>{{ $plan->name }}</strong>
                  @if ($plan->is_popular)<span class="badge badge-danger ml-1">Popular</span>@endif
                  <div class="text-muted small">{{ $plan->description }}</div>
                </td>
                <td>${{ number_format($plan->price_monthly) }}</td>
                <td class="d-none d-md-table-cell">
                  ${{ number_format($plan->effective_yearly_price) }}
                  @if ($plan->yearly_saving_percent > 0)<small class="text-success">−{{ $plan->yearly_saving_percent }}%</small>@endif
                </td>
                <td>
                  @if ($plan->is_active)
                    <span class="badge badge-success">Visible</span>
                  @else
                    <span class="badge badge-secondary">Hidden</span>
                  @endif
                </td>
                <td class="d-none d-lg-table-cell"><a href="{{ route('subscriptions.index') }}">{{ $plan->subscriptions_count }}</a></td>
                <td class="text-nowrap">
                  <a class="btn btn-info btn-sm" title="Edit" href="{{ route('plans.edit', $plan) }}"><i class="fas fa-pencil-alt"></i><span class="d-none d-lg-inline"> Edit</span></a>
                  <form action="{{ route('plans.destroy', $plan) }}" method="post" class="d-inline" data-confirm="Delete the plan “{{ $plan->name }}”? Existing subscriptions keep their data.">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" title="Delete" type="submit"><i class="fas fa-trash"></i><span class="d-none d-lg-inline"> Delete</span></button>
                  </form>
                </td>
              </tr>
            @empty
              <tr><td colspan="7" class="text-center text-muted py-4">No plans yet. <a href="{{ route('plans.create') }}">Create the first one</a>.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection
