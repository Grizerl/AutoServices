@extends('layouts.admin_layouts')
@section('title', 'Blog')
@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Blog posts</h3>
        <div class="card-tools">
          <a href="{{ route('post.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add post</a>
        </div>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-striped">
          <thead>
            <tr>
              <th style="width: 1%">Id</th>
              <th style="width: 25%">Title</th>
              <th>Content</th>
              <th style="width: 1%"></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($post_content as $item)
              <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->title }}</td>
                <td>{{ \Illuminate\Support\Str::limit($item->content, 160) }}</td>
                <td class="text-nowrap">
                  <a class="btn btn-info btn-sm" href="{{ route('post.edit', $item) }}"><i class="fas fa-pencil-alt"></i> Edit</a>
                  <form action="{{ route('post.destroy', $item) }}" method="post" class="d-inline" data-confirm="Delete this post?">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash"></i> Delete</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr><td colspan="4" class="text-center text-muted py-4">No posts yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @if ($post_content->hasPages())
        <div class="card-footer">{{ $post_content->links() }}</div>
      @endif
    </div>
  </div>
</section>
@endsection
