@extends('layouts.admin_layouts')
@section('title', 'Edit post')
@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="card card-primary">
      <div class="card-header"><h3 class="card-title">Edit post</h3></div>
      <form action="{{ route('post.update', $post) }}" method="post">
        @method('PUT')
        @include('admin.post._form', ['submit' => 'Save changes'])
      </form>
    </div>
  </div>
</section>
@endsection
