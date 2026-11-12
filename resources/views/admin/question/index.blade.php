@extends('layouts.admin_layouts')
@section('title', 'Questions')
@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header"><h3 class="card-title">Questions from the contact form</h3></div>
      <div class="card-body table-responsive p-0">
        <table class="table table-striped">
          <thead>
            <tr>
              <th class="d-none d-md-table-cell" style="width: 1%">Id</th>
              <th>Customer name</th>
              <th>Phone</th>
              <th class="d-none d-lg-table-cell">Email</th>
              <th>Message</th>
              <th class="d-none d-lg-table-cell">Received</th>
              <th style="width: 1%"></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($contact as $item)
              <tr>
                <td class="d-none d-md-table-cell">{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td class="text-nowrap"><a href="tel:{{ preg_replace('/[^\d+]/', '', $item->phone) }}">{{ $item->phone }}</a></td>
                <td class="d-none d-lg-table-cell">@if ($item->email)<a href="mailto:{{ $item->email }}">{{ $item->email }}</a>@else<span class="text-muted">&mdash;</span>@endif</td>
                <td style="min-width: 220px">{{ $item->message }}</td>
                <td class="text-nowrap d-none d-lg-table-cell">{{ $item->created_at?->format('Y-m-d H:i') }}</td>
                <td>
                  <form action="{{ route('contact.destroy', $item) }}" method="post" data-confirm="Delete this question?">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" title="Delete" type="submit"><i class="fas fa-trash"></i><span class="d-none d-lg-inline"> Delete</span></button>
                  </form>
                </td>
              </tr>
            @empty
              <tr><td colspan="7" class="text-center text-muted py-4">No questions yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @if ($contact->hasPages())
        <div class="card-footer">{{ $contact->links() }}</div>
      @endif
    </div>
  </div>
</section>
@endsection
