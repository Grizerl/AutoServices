@extends('layouts.admin_layouts')
@section('title', 'Cars for sale')
@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Cars for sale</h3>
        <div class="card-tools d-flex align-items-center">
          <form method="get" class="mr-2">
            <select name="status" class="form-control form-control-sm" onchange="this.form.submit()" aria-label="Filter by status">
              <option value="">All statuses</option>
              @foreach (\App\Models\Car::STATUSES as $key => $label)
                <option value="{{ $key }}" @selected($status === $key)>{{ $label }}</option>
              @endforeach
            </select>
          </form>
          <a href="{{ route('cars.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add car</a>
        </div>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-striped">
          <thead>
            <tr>
              <th style="width: 1%">Photo</th>
              <th>Car</th>
              <th class="d-none d-md-table-cell">Year</th>
              <th class="d-none d-lg-table-cell">Mileage</th>
              <th>Price</th>
              <th>Status</th>
              <th class="d-none d-lg-table-cell">Requests</th>
              <th style="width: 1%"></th>
            </tr>
          </thead>
          <tbody>
            @php($badges = ['available' => 'success', 'reserved' => 'warning', 'sold' => 'secondary'])
            @forelse ($cars as $car)
              <tr>
                <td><img src="{{ $car->image_url }}" alt="{{ $car->title }}" style="width: 72px; height: 54px; object-fit: cover; border-radius: 6px;"></td>
                <td>
                  <strong>{{ $car->title }}</strong>
                  @if ($car->is_featured)<i class="fas fa-star text-warning ml-1" title="Featured"></i>@endif
                  <div class="text-muted small d-lg-none">{{ $car->year }} · {{ number_format($car->mileage) }} km</div>
                </td>
                <td class="d-none d-md-table-cell">{{ $car->year }}</td>
                <td class="d-none d-lg-table-cell">{{ number_format($car->mileage) }} km</td>
                <td class="text-nowrap">
                  ${{ number_format($car->price) }}
                  @if ($car->discount_percent)<small class="text-danger ml-1"><s>${{ number_format($car->old_price) }}</s></small>@endif
                </td>
                <td><span class="badge badge-{{ $badges[$car->status] ?? 'secondary' }}">{{ $car->status_label }}</span></td>
                <td class="d-none d-lg-table-cell">
                  <a href="{{ route('car-inquiries.index') }}">{{ $car->inquiries_count }}</a>
                </td>
                <td class="text-nowrap">
                  <a class="btn btn-default btn-sm" title="View on site" href="{{ route('car.show', $car) }}" target="_blank" rel="noopener"><i class="fas fa-external-link-alt"></i></a>
                  <a class="btn btn-info btn-sm" title="Edit" href="{{ route('cars.edit', $car) }}"><i class="fas fa-pencil-alt"></i><span class="d-none d-lg-inline"> Edit</span></a>
                  <form action="{{ route('cars.destroy', $car) }}" method="post" class="d-inline" data-confirm="Delete {{ $car->title }}? Its requests will be deleted too.">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" title="Delete" type="submit"><i class="fas fa-trash"></i><span class="d-none d-lg-inline"> Delete</span></button>
                  </form>
                </td>
              </tr>
            @empty
              <tr><td colspan="8" class="text-center text-muted py-4">No cars yet. <a href="{{ route('cars.create') }}">Add the first one</a>.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @if ($cars->hasPages())
        <div class="card-footer">{{ $cars->links() }}</div>
      @endif
    </div>
  </div>
</section>
@endsection
