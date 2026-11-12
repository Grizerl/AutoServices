@extends('layouts.admin_layouts')
@section('title', 'Team')
@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Employees</h3>
        <div class="card-tools">
          <a href="{{ route('members.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add member</a>
        </div>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-striped">
          <thead>
            <tr>
              <th style="width: 1%">Id</th>
              <th style="width: 1%">Photo</th>
              <th>Name</th>
              <th>Role</th>
              <th>Phone</th>
              <th style="width: 1%"></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($members as $member)
              <tr>
                <td>{{ $member->id }}</td>
                <td><img src="{{ $member->image_url }}" alt="{{ $member->name }}" class="img-circle" style="width: 48px; height: 48px; object-fit: cover;"></td>
                <td>{{ $member->name }}</td>
                <td>{{ $member->role }}</td>
                <td>{{ $member->phone_number }}</td>
                <td class="text-nowrap">
                  <a class="btn btn-primary btn-sm" href="{{ route('members.show', $member) }}"><i class="fas fa-folder"></i> View</a>
                  <a class="btn btn-info btn-sm" href="{{ route('members.edit', $member) }}"><i class="fas fa-pencil-alt"></i> Edit</a>
                  <form action="{{ route('members.destroy', $member) }}" method="post" class="d-inline" data-confirm="Delete {{ $member->name }}?">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash"></i> Delete</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr><td colspan="6" class="text-center text-muted py-4">No team members yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @if ($members->hasPages())
        <div class="card-footer">{{ $members->links() }}</div>
      @endif
    </div>
  </div>
</section>
@endsection
