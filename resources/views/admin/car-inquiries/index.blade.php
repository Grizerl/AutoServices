@extends('layouts.admin_layouts')
@section('title', 'Car requests')
@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Requests for cars</h3>
        <div class="card-tools">
          <form method="get">
            <select name="status" class="form-control form-control-sm" onchange="this.form.submit()" aria-label="Filter by status">
              <option value="">All statuses</option>
              @foreach (\App\Models\CarInquiry::STATUSES as $key => $label)
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
              <th>Car</th>
              <th>Customer</th>
              <th class="d-none d-md-table-cell">Message</th>
              <th class="d-none d-lg-table-cell">Received</th>
              <th>Status</th>
              <th style="width: 1%"></th>
            </tr>
          </thead>
          <tbody>
            @php($badges = ['new' => 'danger', 'contacted' => 'info', 'closed' => 'secondary'])
            @forelse ($inquiries as $inquiry)
              <tr>
                <td>
                  @if ($inquiry->car)
                    <a href="{{ route('cars.edit', $inquiry->car) }}">{{ $inquiry->car->title }}</a>
                    <div class="text-muted small">{{ $inquiry->car->year }} · ${{ number_format($inquiry->car->price) }}</div>
                  @else
                    <span class="text-muted">deleted car</span>
                  @endif
                </td>
                <td>
                  {{ $inquiry->name }}
                  <div class="small"><a href="tel:{{ preg_replace('/[^\d+]/', '', $inquiry->phone) }}">{{ $inquiry->phone }}</a></div>
                  @if ($inquiry->email)<div class="small"><a href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a></div>@endif
                </td>
                <td class="d-none d-md-table-cell" style="min-width: 200px">{{ $inquiry->message ?: '—' }}</td>
                <td class="d-none d-lg-table-cell text-nowrap">{{ $inquiry->created_at?->format('Y-m-d H:i') }}</td>
                <td><span class="badge badge-{{ $badges[$inquiry->status] ?? 'secondary' }}">{{ $inquiry->status_label }}</span></td>
                <td class="text-nowrap">
                  <form action="{{ route('car-inquiries.update', $inquiry) }}" method="post" class="d-inline-flex">
                    @csrf @method('PATCH')
                    <select name="status" class="form-control form-control-sm mr-1" onchange="this.form.submit()" aria-label="Change status">
                      @foreach (\App\Models\CarInquiry::STATUSES as $key => $label)
                        <option value="{{ $key }}" @selected($inquiry->status === $key)>{{ $label }}</option>
                      @endforeach
                    </select>
                  </form>
                  <form action="{{ route('car-inquiries.destroy', $inquiry) }}" method="post" class="d-inline" data-confirm="Delete this request?">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" title="Delete" type="submit"><i class="fas fa-trash"></i></button>
                  </form>
                </td>
              </tr>
            @empty
              <tr><td colspan="6" class="text-center text-muted py-4">No requests yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @if ($inquiries->hasPages())
        <div class="card-footer">{{ $inquiries->links() }}</div>
      @endif
    </div>
  </div>
</section>
@endsection
