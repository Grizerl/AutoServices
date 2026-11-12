@extends('layouts.admin_layouts')
@section('title', 'Reviews')
@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Customer reviews</h3>
        <div class="card-tools">
          <a href="{{ route('client.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add review</a>
        </div>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-striped">
          <thead>
            <tr>
              <th class="d-none d-md-table-cell" style="width: 1%">Id</th>
              <th>Customer name</th>
              <th class="d-none d-lg-table-cell">Role / car</th>
              <th>Comment</th>
              <th class="d-none d-lg-table-cell">Date</th>
              <th style="width: 1%"></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($client as $customer)
              <tr>
                <td class="d-none d-md-table-cell">{{ $customer->id }}</td>
                <td>{{ $customer->name }}</td>
                <td class="d-none d-lg-table-cell">{{ $customer->role }}</td>
                <td>{{ \Illuminate\Support\Str::limit($customer->commentars, 120) }}</td>
                <td class="text-nowrap d-none d-lg-table-cell">{{ $customer->created_at?->format('Y-m-d') }}</td>
                <td class="text-nowrap">
                  <a class="btn btn-info btn-sm" title="Edit" href="{{ route('client.edit', $customer) }}"><i class="fas fa-pencil-alt"></i><span class="d-none d-lg-inline"> Edit</span></a>
                  <form action="{{ route('client.destroy', $customer) }}" method="post" class="d-inline" data-confirm="Delete this review?">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" title="Delete" type="submit"><i class="fas fa-trash"></i><span class="d-none d-lg-inline"> Delete</span></button>
                  </form>
                </td>
              </tr>
            @empty
              <tr><td colspan="6" class="text-center text-muted py-4">No reviews yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @if ($client->hasPages())
        <div class="card-footer">{{ $client->links() }}</div>
      @endif
    </div>
  </div>
</section>
@endsection
