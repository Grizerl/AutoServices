@extends('layouts.admin_layouts')
@section('title', 'Add post')
@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="card card-primary">
      <div class="card-header"><h3 class="card-title">Add post</h3></div>
      <form action="{{ route('post.store') }}" method="post">
        @include('admin.post._form', ['submit' => 'Create post'])
      </form>
    </div>
  </div>
</section>
@endsection
