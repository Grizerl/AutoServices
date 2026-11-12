@extends('layouts.admin_layouts')
@section('title', 'Repair requests')
@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header"><h3 class="card-title">Repair requests</h3></div>
      <div class="card-body table-responsive p-0">
        <table class="table table-striped">
          <thead>
            <tr>
              <th style="width: 1%">Id</th>
              <th>Customer name</th>
              <th>Phone</th>
              <th>Car</th>
              <th>Problem</th>
              <th>Status</th>
              <th>Received</th>
              <th style="width: 1%"></th>
            </tr>
          </thead>
          <tbody>
            @php($badges = ['pending' => 'warning', 'in_progress' => 'info', 'completed' => 'success'])
            @forelse ($repair as $car)
              <tr>
                <td>{{ $car->id }}</td>
                <td>{{ $car->name }}</td>
                <td class="text-nowrap"><a href="tel:{{ preg_replace('/[^\d+]/', '', $car->telephone) }}">{{ $car->telephone }}</a></td>
                <td>{{ $car->car }}</td>
                <td style="min-width: 200px">{{ \Illuminate\Support\Str::limit($car->comment, 100) }}</td>
                <td><span class="badge badge-{{ $badges[$car->done] ?? 'secondary' }}">{{ $car->status_label }}</span></td>
                <td class="text-nowrap">{{ $car->created_at?->format('Y-m-d H:i') }}</td>
                <td class="text-nowrap">
                  <a class="btn btn-primary btn-sm" href="{{ route('repair.show', $car) }}"><i class="fas fa-folder"></i> View</a>
                  <a class="btn btn-info btn-sm" href="{{ route('repair.edit', $car) }}"><i class="fas fa-pencil-alt"></i> Edit</a>
                  <form action="{{ route('repair.destroy', $car) }}" method="post" class="d-inline" data-confirm="Delete this repair request?">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash"></i> Delete</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr><td colspan="8" class="text-center text-muted py-4">No repair requests yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @if ($repair->hasPages())
        <div class="card-footer">{{ $repair->links() }}</div>
      @endif
    </div>
  </div>
</section>
@endsection
